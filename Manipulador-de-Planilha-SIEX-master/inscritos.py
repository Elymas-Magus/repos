from unidecode import unidecode
import PySimpleGUI as sg
import pandas as pd
import nltk
import user_msg as umsg

class INSCRITOS:
    def __init__ (self, path = 'plan/inscritos', nome = "inscritos.xlsx"):
        address = path + "/" + nome
        self.address = address
        self.nome = nome
        self.CPF_LEN = 11
        self.removed = False
        self.stopwords = nltk.corpus.stopwords.words("portuguese")


        print("Lendo Planilha Inscritos-------------------------------------------------------------\n")
        self.plan = pd.read_excel(r"" + address.replace('/', "\\"))

        chaves = self.plan.keys()
        for chave in chaves:
            if "nome" in chave.lower():
                self.col_name = chave

            elif "cpf" in chave.lower():
                self.col_cpf = chave

            elif "email" in chave.lower().replace("-", ""):
                self.col_email = chave

        # filtra pelo nome e cpf
        self.corrige_nome ()
        self.corrige_cpf ()
        self.drop_duplicates ()
        self.sort ()

        pronto = umsg.Success("Inserção finalizada com Sucesso!")
        pronto.show ()


    def lower_names (self):
        nomes = list(self.plan[self.col_name])

        for i in range(len(nomes)):
            self.plan[self.col_name].loc[i] = nomes.lower().strip()


    def corrige_nome (self):
        try:
            nomes = list(self.plan[self.col_name])

            i = 0
            for nome in nomes:
                parts = nltk.word_tokenize(nome)

                new = ""
                for part in parts:
                    if part not in self.stopwords:
                        new += part[0].upper() + part[1:].lower() + " "
                    else:
                        new += part.lower() + " "

                self.plan[self.col_name].loc[i] = new.strip()
                i += 1
        except:
            erro = umsg.Error ("Erro ao corrigir nome")
            erro.show()


    def corrige_cpf (self):
        cpfs = list (self.plan[self.col_cpf])

        for i in range(len(cpfs)):
            cpf = str(cpfs[i]).zfill(self.CPF_LEN)
            self.plan[self.col_cpf].loc[i] = cpf.replace(".", "").replace(",", "").replace("-", "")

        
    def plan_groupby (self, find_by):
        plan = self.padronize_plan ()

        print ("Encontrando duplicatas-----------------------")

        return dict(list(plan.groupby([find_by])))
        

        
    def get_duplicates (self, find_by):
        original = self.plan
        duplicates = self.plan_groupby (find_by)

        to_return = []
        for item in duplicates:
            if len(duplicates[item]) > 1:
                temp = original.loc[list(duplicates[item].index), [self.col_email, self.col_name, self.col_cpf]]
                to_return.append(temp)

        return to_return

    
    @staticmethod
    def padronize_word (string):
        return unidecode(string.lower())

    
    def padronize_plan (self):
        try:
            plan = self.plan.copy()

            for i in list(plan[self.col_name].keys()):
                nome = plan[self.col_name].loc[i]
                plan[self.col_name].loc[i] = self.padronize_word (nome)

            return plan
        except:
            erro = umsg.Error("Erro ao padronizar nomes")
            erro.show ()

            return None

        
    def find_duplicates (self, find_by):
        original = self.plan
        duplicates = self.plan_groupby (find_by)

        to_return = []
        for item in duplicates:
            if len(duplicates[item]) > 1:
                temp = original.loc[list(duplicates[item].index), [self.col_email, self.col_name, self.col_cpf]]
                to_return.append(temp.sort_index())
                # print (item, ": ")
                # print (temp, "\n")
                # print ("********************************************\n")

        # table = umsg.Table(to_return)
        # table.show()

        return to_return


    def remove_duplicates (self):
        try:
            plan = self.plan
            chaves = plan.keys()

            msg = [
                [sg.Text('Essa função é dividida em 3 etapas:\t\n')],
                [sg.Text('1ª: Remoção de duplicatas pelo nome\t')],
                [sg.Text('2ª: Remoção de duplicatas pelo CPF\t')],
                [sg.Text('3ª: Remoção de duplicatas pelo e-mail\t\n')],
                [sg.Button('Fechar Alerta', size=(30, 2))]
            ]

            alert = sg.Window("Alerta!").layout(msg)

            button, values = alert.Read ()
            alert.close ()

            while True:
                r = self.drop("Nome", self.col_name)
                if r:
                    break
                else:
                    return False

            print ("\n")

            while True:
                r = self.drop("CPF", self.col_cpf)
                if r:
                    break
                else:
                    return False

            print ("\n")

            while True:
                r = self.drop("E-mail", self.col_email)
                if r:
                    break
                else:
                    return False

            if self.removed:
                pronto = umsg.Success("Remoção concluida com sucesso!")
                pronto.show()

                self.removed = False

            return True
        except:
            erro = umsg.Error ("Erro ao remover duplicatas")
            erro.show ()

            return False



    def drop (self, tipo, col):
        try:
            any_more = [
                [sg.Text('Deseja remover mais alguma linha?')],
                [sg.Radio('Sim', 'rmv', key='sim'), sg.Radio('Não', 'rmv', key='nao')],
                [sg.Button("Ok")]
            ]

            remove = [
                [sg.Text("Insira o(s) indice(s) da(s) linha(s) que deseja remover")],
                [sg.Text("Indice: "), sg.Input(key="to_rmv")],
                [sg.Button("OK", size=(46, 1))],
            ]

            wind_rmv = sg.Window("Remover Duplicatas").layout(remove)
            w_any_more = sg.Window("Mais alguma?").layout(any_more)
        except:
            erro = umsg.Error ("Erro ao abrir página")
            erro.show ()

        try:
            title = "Removendo duplicatas pelo {}".format(tipo)
            print ("\n{}-------------------------\n".format(title))
            duplicates = self.find_duplicates(col)

            if len(duplicates) == 0:
                if not self.removed:
                    sucesso = umsg.Success("Nenhuma duplicata foi encontrada!")
                    sucesso.show()
                    
                return True

            table = umsg.Table(duplicates, title)
            table.show()

            button, values = wind_rmv.Read ()

            if button == sg.WINDOW_CLOSED:
                wind_rmv.close ()
                return False

            if button == 'OK':
                wind_rmv.close ()

                if len(values['to_rmv']) == 0:
                    return False

            dupl_list = []
            for duplicate in duplicates:
                for item in list(duplicate.index):
                    dupl_list.append(item)

            to_rmv = nltk.word_tokenize(values["to_rmv"])

            responses = []
            for row in to_rmv:
                if int(row) in dupl_list:
                    self.plan.drop(int(row), inplace=True)
                    responses.append("{} Removido com sucesso!".format(row))
                    
                else:
                    responses.append("({}) Ação proibida!\nRemova apenas as linhas inidicadas acima!".format(row))

            r_list = umsg.SuccessList(responses)
            r_list.show()

            table.events ()
                
            button, values = w_any_more.Read()
            w_any_more.close()

            self.removed = True

            return values['nao']
        except:
            erro = umsg.Error("Nenhuma duplicata removida")
            erro.show ()

            return False


    def get_siex_info_dict (self):
        try:
            self.sort ()
            return {
                "Nome": list(self.plan[self.col_name]),
                "CPF": list(self.plan[self.col_cpf])
            }
        except:
            erro = umsg.Error ("Erro ao recuperar dados")
            erro.show ()

            return None


    def get_siex_info_list (self):
        try:
            self.sort ()
            nomes = list(self.plan[self.col_name])
            cpf =  list(self.plan[self.col_cpf])

            siex_list = []

            for i in range(len(nomes)):
                siex_list.append([nomes[i], str(cpf[i])])

            return siex_list
        except: 
            erro = umsg.Error ("Erro ao recuperar dados")
            erro.show ()

            return None

    
    def get_email (self):
        try:
            self.sort ()
            return {
                "nomes": list(self.plan[self.col_name]),
                "email":  list(self.plan[self.col_email])
            }
        except: 
            erro = umsg.Error ("Erro ao recuperar dados")
            erro.show ()

            return None

    
    def create_df_email (self):
        return pd.DataFrame(data=self.get_email ())


    def drop_duplicates (self, auto = False):
        try:
            if auto:
                self.plan = self.plan.drop_duplicates()
            else:
                self.plan = self.plan.drop_duplicates([self.col_name, self.col_cpf], 'last')
        except:
            erro = umsg.Error("Erro ao remover duplicatas óbvias")
            erro.show ()


    def sort (self):
        try:
            self.plan.sort_values([self.col_name, self.col_cpf], inplace=True)
        except:
            erro = umsg.Error ("Erro ao ordenar planilha")
            erro.show ()


    def find_data (self):
        try:
            find = [
                [sg.Text('Pesquisar:'), sg.Input(key='search')],
                [sg.Text('Pesquisar por:')],
                [sg.Radio('Nome', 'search_by', key='nome'), sg.Radio('CPF', 'search_by', key='cpf')],
                [sg.Button('Pesquisar')]
            ]
            
            w_search = sg.Window('Pesquisar (Inscritos)').layout(find)

            button, values = w_search.Read()
            plan = self.plan

            search = values['search']

            if button == sg.WINDOW_CLOSED:
                return

            if values['nome']:
                col = self.col_name

            elif values['cpf']:
                col = self.col_cpf

            elif not values['nome'] and not values['cpf']:
                erro = umsg.Error('Escolha uma coluna')
                erro.show()
                w_search.close()
                self.find_data()
                return

            w_search.close()

            aba = []
            to_find = unidecode(search.lower())

            for i in range(plan[col].count()):
                temp = plan.loc[i, col]
                if to_find in unidecode(temp.lower()):
                    aba.append(i)

        except:
            erro = umsg.Error ("Erro ao encontrar inscrito")
            erro.show ()

            # aba = filter (self.compar, list(plan[col]))

        try:
            df = plan.loc[aba, col]
            if len(aba) != 0:
                output = [
                    [sg.Listbox(values=self.show_df(dict(df)), size=(45, 10))],
                    [sg.Button('Fechar', key='close')],
                ]
            else:
                output = [
                    [sg.Text('Não Encontrado')],
                    [sg.Button('Fechar', key='close')],
                ]

            w_output = sg.Window ('Resposta').layout(output)
            r_button, r_values = w_output.Read ()

            if r_button in (sg.WINDOW_CLOSED, 'close'):
                w_output.close ()
                return
        except:
            erro = umsg.Error ("Erro ao apresentar resposta")
            erro.show ()


    @staticmethod
    def show_df (df):
        response = []
        for i in df:
            temp = "{}: {}\n"
            response.append(temp.format(i + 2, df[i]))
        
        return tuple(response)


    def compar (self, item):
        if self.to_find in unidecode(item.lower()):
            return True
        else:
            return False

        
    @staticmethod
    def save (plan, output_path, output_name):
        try:
            output = "{}/{}.xls".format(output_path, output_name)

            w_save.close()

            # Criar data frame de dados aleatórios
            df = pd.DataFrame(np.random.randint(0,100,size=(20, 4)), columns=list('ABCD'))

            # Criar objeto para leitura e selecionar planilha
            excel_reader = plan
            to_update = { "Plan1": df }

            # Criar objeto para escrita
            excel_writer = pd.ExcelWriter(output)

            for sheet in sheet_names:
                sheet_df = excel_reader[sheet]
                append_df = to_update.get(sheet)

                # Concatenar com o que já existia
                if append_df is not None:
                    sheet_df = pd.concat([sheet_df, df]).drop_duplicates()

                # Gravar no arquivo
                sheet_df.to_excel(excel_writer, sheet, index=False)

            # Salvar e fechar arquivo
            excel_writer.save()
            
            pronto = umsg.Success ('Planilha Salva com Sucesso!')
            pronto.show()

            return True
        except:
            erro = umsg.Error ("Erro ao salvar planilha")
            erro.show ()

            return False

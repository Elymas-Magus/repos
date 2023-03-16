from unidecode import unidecode
import PySimpleGUI as sg
import user_msg as umsg
import inscritos as ic
import siex as sx
import nltk
import os

default = {
    "nome": "live",
    "data": "--/--/--",
    "horas": 1,
    "nro": 1
}


class LIVE:
    def __init__ (self, info = default):
        self.nome = info['nome']
        self.data = info['data']
        self.horas = info['horas']
        self.nro = info['nro']
        self.modalidade = ('Palestra', 'Mesa Redonda')
        self.passaporte = ''
        self.error = False

        invalid = [
            [sg.Text('Operação Inválida!')],
            [sg.OK()],
        ]

        # Janelas
        self.w_invalid = sg.Window('Operação Inválida', size=(230, 75)).layout(invalid)

        self.siex = self.create_siex ()
        self.inscritos = self.create_inscritos ()


    def create_inscritos (self):
        inscritos = [
            [sg.Text('Pasta'), sg.Input(key='path')],
            [sg.Text('Nome'), sg.Input(key='nome')],
            [sg.OK(), sg.Cancel()],
        ]

        w_inscritos = sg.Window("Instanciando Inscritos").layout(inscritos)

        while True:
            button, values = w_inscritos.Read()

            path = values['path']
            nome = values['nome']
            address = "{}\\{}".format(path, nome)
            
            if len(path) and len(nome):
                address = "{}\\{}".format(path, nome)

            elif not len(path) and len(nome):
                address = "plan\\inscritos\\{}".format(nome)

            elif len(path) and not len(nome):
                address = "{}\\inscritos.xlsx".format(path)

            if not os.path.exists(address):
                msg_error = [
                    [sg.Text('Arquivo não encontrado!')],
                    [sg.OK()]
                ]

                error = sg.Window("Erro").layout(msg_error)

                event, values = error.Read()
                error.close()
                continue

            if button in (sg.WINDOW_CLOSED, 'Cancel'):
                self.error = True
                w_inscritos.close()
                return None

            elif not len(path) and not len(nome):
                w_inscritos.close()
                return ic.INSCRITOS()

            elif not len(path):
                w_inscritos.close()
                return ic.INSCRITOS(nome=nome)
                
            else:
                w_inscritos.close()
                return ic.INSCRITOS(path, nome)

    def create_siex (self):
        siex = [
            [sg.Text('Pasta'), sg.Input(key='path')],
            [sg.Text('Nome'), sg.Input(key='nome')],
            [sg.OK(), sg.Cancel()],
        ]
        
        w_siex = sg.Window("Instanciando Siex").layout(siex)
        while True:
            button, values = w_siex.Read()

            path = values['path']
            nome = values['nome']
            address = "{}/{}".format(path, nome)

            if len(path) and len(nome):
                address = "{}/{}".format(path, nome)

            elif not len(path) and len(nome):
                address = "plan/inscritos/{}".format(nome)

            elif len(path) and not len(nome):
                address = "{}/inscritos.xlsx".format(path)

            if not os.path.exists(address):
                msg_error = [
                    [sg.Text('Arquivo não encontrado!')],
                    [sg.OK()]
                ]

                error = sg.Window("Erro").layout(msg_error)

                event, values = error.Read()
                error.close()
                continue

            if button in (sg.WINDOW_CLOSED, 'Cancel'):
                self.error = True
                w_siex.close()
                return None

            elif len(path) == 0 and len(nome) == 0:
                w_siex.close()
                return sx.SIEX()

            elif len(path) == 0:
                w_siex.close()
                return sx.SIEX(nome=nome)

            else:
                w_siex.close()
                return sx.SIEX(path, nome)

        
    def menu (self):
        menu = [
            [sg.Radio('Salvar planilha SIEX', 'menu')],
            [sg.Radio('Remover duplicatas', 'menu')],
            [sg.Radio('Inserir participantes', 'menu')],
            [sg.Radio('Inserir Ministrante', 'menu')],
            [sg.Radio('Inserir Interprete', 'menu')],
            [sg.Radio('Pesquisar na planilha SIEX', 'menu')],
            [sg.Radio('Pesquisar na planilha Inscritos', 'menu')],
            [sg.Radio('Encontrar duplicatas', 'menu')],
            [sg.Button('Executar')],
        ]

        w_menu = sg.Window('Menu de operação Inscritos').layout(menu)
        button, values = w_menu.Read()
        w_menu.close()

        for i in values:
            if values[i]:
                self.trata_op (i)
                break


    def invalid_op (self):
        self.button, self.values = self.w_invalid.Read()
        print ("__________________________________________\n")
        self.w_invalid.close ()


    def trata_op (self, op):
        switcher = {
            0: self.siex.save,
            1: self.inscritos.remove_duplicates,
            2: self.inserir_participante,
            3: self.inserir_ministrante,
            4: self.inserir_interprete,
            5: self.siex.find_data,
            6: self.inscritos.find_data,
            7: self.find_duplicates,
        }

        func = switcher.get(op, self.invalid_op)
        func ()


    def find_duplicates (self):
        find_duplo = [
            [sg.Text('Encontrar duplicatas pelo:')],
            [sg.Radio('Nome', 'find_by', key='nome'), sg.Radio('CPF', 'find_by', key='cpf'), sg.Radio('E-mail', 'find_by', key='email')],
            [sg.Button('Procurar')]
        ]
        
        w_find_duplo = sg.Window('Encontrar duplicatas').layout(find_duplo)

        button, values = w_find_duplo.Read()
        w_find_duplo.close()

        duplicates = []
        if values['nome']:
            duplicates = self.inscritos.find_duplicates(self.inscritos.col_name)

        elif values['cpf']:
            duplicates = self.inscritos.find_duplicates(self.inscritos.col_cpf)

        elif values['email']:
            duplicates = self.inscritos.find_duplicates(self.inscritos.col_email)

        if len(duplicates) > 0:
            table = umsg.Table(duplicates)
            table.show()
        else:
            sucesso = umsg.Success("Nenhuma duplicata encontrada")
            sucesso.show()


    def inserir_ministrante (self):
        insert_ministrante = [
            [sg.Text('Nome'), sg.Input(key='nome')],
            [sg.Text('CPF  '), sg.Input(key='cpf')],
            [sg.Radio('Palestra', 'modalidade', key='Palestra'), sg.Radio('Mesa Redonda', 'modalidade', key='Mesa Redonda')],
            [sg.Button('Inserir')],
        ]

        w_inserir_ministrante = sg.Window('Inserir Ministrante').layout(insert_ministrante)

        count = 0
        while True:
            # Tela de inserção
            button, values = w_inserir_ministrante.Read()

            if button == sg.WINDOW_CLOSED:
                w_inserir_ministrante.close()
                break

            if values['Palestra']:
                modalidade = self.modalidade[0]
            else:
                modalidade = self.modalidade[1]
        
            data = [values['nome'], values['cpf'], modalidade, self.nome, self.data, self.horas + 4, self.passaporte]

            self.siex.insert_data (sx.sheet_names[3], data)

            count += 1

            if self.not_again():
                w_inserir_ministrante.close()
                break

        if count:
            pronto = umsg.Success("Inserção finalizada com Sucesso!")
            pronto.show ()


    def not_again (self):
        insert_check = [
            [sg.Text('Deseja inserir mais alguma linha?')],
            [sg.Radio('Sim', 'rmv', key='sim'), sg.Radio('Não', 'rmv', key='nao')],
            [sg.OK()]
        ]

        # Janela
        w_insert_check = sg.Window('Inserir mais algo?').layout(insert_check)

        # Tela de inserir novamente
        button, values = w_insert_check.Read()

        if button in (sg.WINDOW_CLOSED, 'OK'):
            w_insert_check.close()

        # Inserir mais algum ministrante?
        return values['nao']


    def inserir_participante (self):
        if not self.siex.participante:
            d_name = self.inscritos.get_duplicates(self.inscritos.col_name)
            d_cpf = self.inscritos.get_duplicates(self.inscritos.col_cpf)
            d_email = self.inscritos.get_duplicates(self.inscritos.col_email)

            if len(d_name) + len(d_cpf):
                warn = umsg.WarningMsg("Esta planilha contém duplicatas.")
                warn.show()

                quest = umsg.Question ("Deseja remover agora?")
                answer = quest.show ()

                if answer == 'sim':
                    if self.inscritos.remove_duplicates ():
                        self.inserir_participante ()
                        return
                    else:
                        return
                        
                elif answer in (sg.WINDOW_CLOSED, 'nao'):
                    erro = umsg.Error ("Ação Proibida!\nRemova as duplicatas primeiro.")
                    erro.show()

                    return

            elif not len(d_email):
                warn = umsg.WarningMsg("Esta planilha contém emails duplicados.")
                warn.show()

                quest = umsg.Question ("Deseja remover agora?")
                answer = quest.show ()

                if answer == 'sim':
                    if self.inscritos.remove_duplicates ():
                        self.inserir_participante ()
                        return
                    

            self.inscritos.create_df_email ()
            arr = self.inscritos.get_siex_info_list()

            arr.sort (key=cmp)

            for data in arr:
                data.append(self.horas)
                data.append(self.passaporte)
                self.siex.insert_data (sx.sheet_names[1], data)

            pronto = umsg.Success("Inserção finalizada com Sucesso!")
            pronto.show ()

            self.siex.participante = True
        else:
            warn = umsg.WarningMsg("Você já inseriu participantes!")
            warn.show ()

            quest = umsg.Question("Deseja sobrescrever?")
            answer = quest.show()
            plan = self.siex.plan[sx.sheet_names[1]]

            if answer == 'sim':
                self.siex.plan[sx.sheet_names[1]] = plan.drop(index=list(self.siex.plan[sx.sheet_names[1]].index))

                self.siex.participante = False
                self.inserir_participante ()


    def inserir_interprete (self):
        insert_interprete = [
            [sg.Text('Nome'), sg.Input(key='nome')],
            [sg.Text('CPF  '), sg.Input(key='cpf')],
            [sg.Button('Inserir')],
        ]
        
        w_inserir_interprete = sg.Window('Inserir interprete').layout(insert_interprete)

        count = 0
        while True:
            # Tela de inserção
            button, values = w_inserir_interprete.Read()
            funcao = 'Interprete'

            if button == sg.WINDOW_CLOSED:
                w_inserir_interprete.close()
                break

            data = [values['nome'], values['cpf'], funcao, self.horas + 1, self.passaporte]

            self.siex.insert_data (sx.sheet_names[5], data)

            count += 1

            if self.not_again():
                w_inserir_interprete.close()
                break

            # w_inserir_interprete['nome'] = ""
            # w_inserir_interprete['cpf'] = ""
            print(w_inserir_interprete)

        if count:
            pronto = umsg.Success("Inserção finalizada com Sucesso!")
            pronto.show ()

    
    def save (self):
        d_name = self.inscritos.get_duplicates(self.inscritos.col_name)
        d_cpf = self.inscritos.get_duplicates(self.inscritos.col_cpf)
        d_email = self.inscritos.get_duplicates(self.inscritos.col_email)

        if len(d_name) + len(d_cpf) + len(d_email):
            warn = umsg.WarningMsg("Esta planilha contém duplicatas.")
            warn.show()

            quest = umsg.Question ("Deseja remover agora?")
            answer = quest.show ()

            if answer == 'sim':
                if self.inscritos.remove_duplicates ():
                    self.save ()
                else:
                    return
                        
            elif answer in (sg.WINDOW_CLOSED, 'nao'):
                erro = umsg.Error ("Ação Proibida!\nRemova as duplicatas primeiro.")
                erro.show()

                return

        else:
            try:
                if self.siex.save():
                    df = self.inscritos.create_df_email()
                    path = self.siex.output_path
                    nome = self.data

                    self.inscritos.save(df, path, nome)
            except:
                erro = umsg.Error("Erro ao salvar planilhas")
                erro.show()


def cmp (e):
    return unidecode(e[0].lower())
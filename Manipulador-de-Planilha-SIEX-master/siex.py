from unidecode import unidecode
from openpyxl import load_workbook
import PySimpleGUI as sg
import user_msg as umsg
import pandas as pd
import numpy as np
import math

sheet_names = (
    "Participante Modalidade",
    "Participante Geral",
    "Coordenador Geral",
    "Ministrante",
    "Autor Trabalho",
    "Equipe Trabalho",
    "Comissão"
)

class SIEX:
    def __init__ (self, path = 'plan/siex', nome = "siex_blank.xls"):
        address = path + "/" + nome
        self.address = address
        self.nome = nome
        self.participante = False
        self.CPF_LEN = 11
        self.output_path = 'output'
        

        try:
            print("Lendo Planilha SIEX-------------------------------------------------------------------\n")
            self.plan = pd.read_excel(r"" + address.replace('/', "\\"), sheet_name=list(sheet_names))
            # self.sheet_names = self.plan.keys()

            # Converte o CPF de numpy.int64 para string formatada com 11 caracteres
            self.put_zeros ()

            pronto = umsg.Success("Criado com sucesso!")
            pronto.show()
        except:
            erro = umsg.Error("Erro ao inicializar planilha")
            erro.show ()
        
        # print("Pronto!------------------------------------------------------------------------------\n")
        

    def put_zeros (self):
        try:
            print("Corrigindo CPF------------------------------------------------------------------------\n")
            plan = self.plan

            df = pd.DataFrame(np.random.randint(0,100,size=(20, 4)), columns=list('ABCD'))

            for sheet_name in sheet_names:
                sheet = plan[sheet_name]
                for i in range(len(sheet['CPF'])):
                    cpf = str(sheet.CPF[i])
                    if self.isvalid(cpf):
                        self.plan[sheet_name]['CPF'].loc[i] = cpf.zfill(self.CPF_LEN)

            print("\n--------------------------------------------------------------------------------------\n")
        except:
            erro = umsg.Error("Falha ao corrigir formatação dos CPF's")
            erro.show ()

    @staticmethod
    def isvalid(cpf):
        if len(cpf) > 0 and cpf != None and cpf.isnumeric():
            return True
        else:
            return False

    def insert_data (self, sheet, data):
        try:
            plan = self.plan[sheet]
            keys = list(plan.keys())
            tam = plan[keys[0]].count()

            new_row = pd.DataFrame.from_dict(
                { tam: data },
                orient='index',
                columns=keys
            )

            self.plan[sheet] = pd.concat([plan, new_row])
        except:
            erro = umsg.Error ("Falha ao inserir dado")
            erro.show ()

    
    def get_wind_search (self):
        try:
            change_sheet = [
                [sg.Text('Abas')],
            ]

            w_change_col = []
            
            # Janelas
            for sheet_name in sheet_names:
                change_col = [ [sg.Text('Escolha uma coluna: ')] ]
                change_sheet.append([sg.Radio(sheet_name, 'sheetnames', key=sheet_name)])

                for col in self.plan[sheet_name]:
                    change_col.append([sg.Radio(col, 'columns_{sheet_name}', key=col)])
                
                change_col.append([sg.Button('Selecionar')])
                w_change_col.append(sg.Window(sheet_name).layout(change_col))

            change_sheet.append([sg.Button('Selecionar')])
            w_change_sheet = sg.Window('Escolha a aba da planilha').layout(change_sheet)

            return {
                'sheets': w_change_sheet,
                'cols': w_change_col
            }
        except:
            erro = umsg.Error("Erro ao recuperar elemento(s)")
            erro.show ()


    def find_data (self):
        try:
            windows = self.get_wind_search ()
            button, values = windows['sheets'].Read()

            windows['sheets'].close()

            w_change_col = windows['cols']
            for i in range(len(sheet_names)):
                sheet_name = sheet_names[i]
                if values[sheet_name]:
                    button, values = w_change_col[i].Read()
                    break

            for col in values:
                if values[col]:
                    break

            w_change_col[i].close()

            search = [
                [sg.Text('Pesquisar:'), sg.Input(key='search')],
                [sg.Button('Pesquisar')],
            ]

            w_search = sg.Window('Pesquisar (SIEX)').layout(search)
            button, values = w_search.Read()
            search = values['search']

            if search == '':
                w_search.close()
                return

            plan = self.plan[sheet_name]

            w_search.close()

            aba = []
            to_find = unidecode(search.lower())

            for i in range(plan[col].count()):
                temp = plan[col].loc[i]
                if to_find in unidecode(temp.lower()):
                    aba.append(i)

            df = plan.loc[aba, col]
            if len(aba) != 0:
                output = [
                    [sg.Listbox(values=self.show_df(dict(df)), size=(45, 10))],
                    [sg.Button('Fechar')]
                ]
            else:
                output = [
                    [sg.Text('Não Encontrado')],
                    [sg.Button('Fechar')]
                ]
                
            w_output = sg.Window('Resposta').layout(output)
            button, values = w_output.Read()
            w_output.close()
        except:
            erro = umsg.Error("Erro ao encontrar elemento")
            erro.show ()
        

    def drop_duplicates (self, sheet, auto = True):
        if auto:
            self.plan[sheet] = self.plan[sheet].drop_duplicates()
        else:
            self.plan[sheet] = self.plan[sheet].drop_duplicates(['Nome', 'CPF'], 'last')


    @staticmethod
    def show_df (df):
        response = []
        for i in df:
            temp = "{}: {}\n"
            response.append(temp.format(i + 2, df[i]))
        
        return tuple(response)


    def save (self):
        try:
            save = [
                [sg.Text('Deixe o campo de pasta em branco para salva na pasta padrão.')],
                [sg.Text('Pasta: '), sg.Input(key='output_path')],
                [sg.Text('Nome: '), sg.Input(key='output_name')],
                [sg.OK(), sg.Cancel()],
            ]
            
            w_save = sg.Window("Salvando arquivo").layout(save)
            
            button, values = w_save.Read()
            output_name = values['output_name']
            output_path = values['output_path']

            if button in (sg.WINDOW_CLOSED, 'Cancel'):
                return

            if output_path == '':
                output_path = 'output'

            self.output_path = output_path

            output = "{}/{}.xls".format(output_path, output_name)

            w_save.close()

            # Converte o CPF de numpy.int64 para string formatada com 11 caracteres
            self.put_zeros ()
            
            # Criar data frame de dados aleatórios
            df = pd.DataFrame(np.random.randint(0,100,size=(20, 4)), columns=list('ABCD'))

            # Criar objeto para leitura e selecionar planilha
            excel_reader = self.plan
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

        # print ('Planilha Salva com Sucesso!')

    @staticmethod
    def func (x):
        return x + 2


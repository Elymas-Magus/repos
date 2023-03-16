from json import dump, load
import PySimpleGUI as sg
import live as lv
import os
# import pickle

class Main:
    def __init__(self):
        self.str_encode = 'utf-8'
        inicio = [
            [sg.Text('Bem vindo!')],
            [sg.Image(filename='imgs/robot-ico.png', key='image')],
            [sg.Button("Iniciar", size=(26, 2), key="start")],
            [sg.Button("Abrir do histórico", size=(26, 2), key="open")],
            [sg.Button("Fechar", size=(26, 2), key="close")]
        ]

        close = False

        self.live = None
        self.janela_inicial = sg.Window('Manipulador de planilhas SIEX', size=(250, 310)).layout(inicio)

        while True:
            self.button, self.values = self.janela_inicial.Read()

            if self.button == 'start':
                self.iniciar ()
            
            elif self.button == 'open':
                self.abrir ()

            elif self.button in (sg.WIN_CLOSED, 'close'):
                close = True
                break

            elif self.live.inscritos == None or self.live.siex == None or self.live.error:
                close = True
                break

        self.janela_inicial.close()

        if close:
            self.fechar ()

    
    def iniciar (self):
        create = [
            [sg.Text("NOVA LIVE")],
            [sg.Text("Número"), sg.Input(key='nro')],
            [sg.Text("Nome"), sg.Input(key='nome')],
            [sg.Text("Data  "), sg.Input(key='data')],
            [sg.Text("Horas"), sg.Input(key='horas')],
            [sg.Button("Criar", size=(22, 2), key='create'), sg.Button("Voltar", size=(22, 2), key='back')]
        ]

        janela_create = sg.Window('Criar Nova live_doc').layout(create)

        button, values = janela_create.Read()

        if button == 'create':
            data = {
                'nome': values['nome'],
                'data': values['data'],
                'horas': values['horas'],
                'nro': values['nro'],
            }

            self.live = lv.LIVE(data)
            janela_create.close()

            if not self.live.error:
                self.menu_principal ()
            # self.janela_inicial.close()

        elif button in (sg.WIN_CLOSED, 'back'):
            janela_create.close()


    def abrir (self):
        back = [
            [sg.Text ('Deseja continuar?')]
        ]
        
        nav = 'historico.json'

        with open(nav, encoding=self.str_encode) as historico:
            last = load(historico)

        back.append([sg.Text('Número'), sg.Text(last['nro'])])
        back.append([sg.Text('Nome'), sg.Text(last['nome'])])
        back.append([sg.Text('Data  '), sg.Text(last['data'])])
        back.append([sg.Text('Horas'), sg.Text(last['horas'])])
        back.append([sg.Button('Abrir', size=(22, 2), key='start'), sg.Button('Voltar', size=(22, 2), key='back_o')])

        janela_abrir = sg.Window('Abrir Live', back)

        button, values = janela_abrir.Read()

        if button == 'start':
            self.live = lv.LIVE(last)
            janela_abrir.close()

            if not self.live.error:
                self.menu_principal ()

        elif button in (sg.WIN_CLOSED, 'back_o'):
            janela_abrir.close()


    @staticmethod
    def fechar ():
        goodbye = [
            [sg.Text("Até Logo!")],
            [sg.Button("Tchau", size=(30, 2), key='tchau')]
        ]

        janela_final = sg.Window("Volte Sempre!", goodbye)
        button, values = janela_final.Read()

        if button in (sg.WIN_CLOSED, 'tchau'):
            janela_final.close()


    @staticmethod
    def invalid_op ():
        print ("Operação inválida!")

    
    def menu_principal (self):
        layout = [
            [sg.Text('Menu principal')],
            [sg.Button("Recarregar", size=(26, 2), key="refresh")],
            [sg.Button("Salvar no histórico", size=(26, 2), key="story")],
            [sg.Button("Menu", key='menu', size=(12, 2)), sg.Button("Sair", key='close', size=(12, 2))]
        ]

        janela = sg.Window('Manipulador de planilhas SIEX', size=(250, 180)).layout(layout)

        while True:
            button, values = janela.Read()

            if button == 'menu':
                self.live.menu ()

            elif button == 'refresh':
                data = {
                    "nome": self.live.nome,
                    "data": self.live.data,
                    "horas": self.live.horas,
                    "nro": self.live.nro
                }

                self.live = lv.LIVE(data)
                
            elif button in (sg.WINDOW_CLOSED, 'close'):
                janela.close()
                break

            elif button == 'story':
                sorry = [
                    [sg.Text('Por motivos técnicos essa funcionalidade\nnão está em seu melhor estado')],
                    [sg.Text('Ao salvar a planilha, na verdade é salvo\napenas o nome a data e o carga horária da live')],
                    [sg.Button('Ok, Entendi')]
                ]

                window_sorry = sg.Window("Me desculpe!").layout(sorry)
                button, values = window_sorry.Read()
                window_sorry.close()

                data = {
                    "nome": self.live.nome,
                    "data": self.live.data,
                    "horas": self.live.horas,
                    "nro": self.live.nro
                }

                path = "{}\historico.json".format(os.getcwd())

                os.remove(path)

                with open (path, 'w') as file:
                    dump (data, file, indent=4)
                    
                print ('Live salva no histórico!')


prog = Main ()
import PySimpleGUI as sg
import numpy as np

class Game:
    def __init__ (self):
        self.card = 0
        self.layout = [
            [sg.Text("Escolha uma carta:")],
            [
                sg.Image(filename="cartas/1.png"),
                sg.Image(filename="cartas/2.png"),
                sg.Image(filename="cartas/3.png"),
                sg.Image(filename="cartas/4.png"),
                sg.Image(filename="cartas/5.png"),
            ],
            [
                sg.Image(filename="cartas/6.png"),
                sg.Image(filename="cartas/7.png"),
                sg.Image(filename="cartas/8.png"),
                sg.Image(filename="cartas/9.png"),
                sg.Image(filename="cartas/10.png"),
            ],
            [
                sg.Image(filename="cartas/11.png"),
                sg.Image(filename="cartas/12.png"),
                sg.Image(filename="cartas/13.png"),
                sg.Image(filename="cartas/14.png"),
                sg.Image(filename="cartas/15.png"),
            ],
            [sg.Button("Já escolhi!", size=(68, 3), key='changed')]
        ]

        self.main_window = sg.Window("Escolha uma carta").layout(self.layout)

    def show (self):
        self.button, self.values = self.main_window.Read()

        if self.button == sg.WINDOW_CLOSED:
            return

        if self.button == 'changed':
            self.main_window.close()
            self.verify ()

    def verify (self):
        self.first ()
        self.second ()
        self.third ()
        self.fourth ()
        
        if not self.responses():
            layout = [
                [sg.Text("Tem certeza?", font="Courier 20")],
                [sg.Button("Sim", size=(15, 2), key="sim"), sg.Button("Não", size=(15, 2), key="nao")],
                [sg.Button("Fechar", size=(32, 2), key="close")]
            ]

            tem_certeza = sg.Window("Pense bem", layout)

            button, values = tem_certeza.Read()

            if button == "sim":
                tem_certeza.close()

            elif button in (sg.WINDOW_CLOSED, "close"):
                tem_certeza.close()
                return

            elif button == "nao":
                tem_certeza.close()
                self.verify()
                return
            
            layout = [
                [sg.Text("Mentir é feio!!!", font="Courier 20")],
                [sg.Button("Tentar novo", size=(15, 2), key="again"), sg.Button("Sair", size=(15, 2), key="close")]
            ]

            window = sg.Window("¯\_(ツ)_/¯", layout)

            button, values = window.Read()

            if button in (sg.WINDOW_CLOSED, "close"):
                window.close()
                return

            elif button == "again":
                window.close()
                self.verify()
                return


    def first (self):
        cartas = np.array([1, 3, 5, 7, 9, 11, 13, 15])
        np.random.shuffle(cartas.T)

        self.layout = [
            [sg.Text("Sua carta está aqui?")],
            [
                sg.Image(filename="cartas/{}.png".format(cartas[0])),
                sg.Image(filename="cartas/{}.png".format(cartas[1])),
                sg.Image(filename="cartas/{}.png".format(cartas[2])),
                sg.Image(filename="cartas/{}.png".format(cartas[3])),
            ],
            [
                sg.Image(filename="cartas/{}.png".format(cartas[4])),
                sg.Image(filename="cartas/{}.png".format(cartas[5])),
                sg.Image(filename="cartas/{}.png".format(cartas[6])),
                sg.Image(filename="cartas/{}.png".format(cartas[7])),
            ],
            [sg.Button("Sim", size=(26, 2), key='sim'), sg.Button("Não", size=(26, 2), key='nao')]
        ]

        self.first_window = sg.Window("Sua carta está nesta página?").layout(self.layout)

        self.button, self.values = self.first_window.Read()
        
        if self.button == sg.WINDOW_CLOSED:
            return

        if self.button == 'sim':
            self.card += 1
            self.first_window.close()
            return

        if self.button == 'nao':
            self.first_window.close()
            return

    def second (self):
        cartas = np.array([2, 3, 6, 7, 10, 11, 14, 15])
        np.random.shuffle(cartas.T)

        self.layout = [
            [sg.Text("Sua carta está aqui?")],
            [
                sg.Image(filename="cartas/{}.png".format(cartas[0])),
                sg.Image(filename="cartas/{}.png".format(cartas[1])),
                sg.Image(filename="cartas/{}.png".format(cartas[2])),
                sg.Image(filename="cartas/{}.png".format(cartas[3])),
            ],
            [
                sg.Image(filename="cartas/{}.png".format(cartas[4])),
                sg.Image(filename="cartas/{}.png".format(cartas[5])),
                sg.Image(filename="cartas/{}.png".format(cartas[6])),
                sg.Image(filename="cartas/{}.png".format(cartas[7])),
            ],
            [sg.Button("Sim", size=(26, 2), key='sim'), sg.Button("Não", size=(26, 2), key='nao')]
        ]

        self.sec_window = sg.Window("Sua carta está nesta página?").layout(self.layout)

        self.button, self.values = self.sec_window.Read()

        if self.button == sg.WINDOW_CLOSED:
            return

        if self.button == 'sim':
            self.card += 2
            self.sec_window.close()
            return

        if self.button == 'nao':
            self.sec_window.close()
            return

    def third (self):
        cartas = np.array([4, 5, 6, 7, 12, 13, 14, 15])
        np.random.shuffle(cartas.T)

        self.layout = [
            [sg.Text("Sua carta está aqui?")],
            [
                sg.Image(filename="cartas/{}.png".format(cartas[0])),
                sg.Image(filename="cartas/{}.png".format(cartas[1])),
                sg.Image(filename="cartas/{}.png".format(cartas[2])),
                sg.Image(filename="cartas/{}.png".format(cartas[3])),
            ],
            [
                sg.Image(filename="cartas/{}.png".format(cartas[4])),
                sg.Image(filename="cartas/{}.png".format(cartas[5])),
                sg.Image(filename="cartas/{}.png".format(cartas[6])),
                sg.Image(filename="cartas/{}.png".format(cartas[7])),
            ],
            [sg.Button("Sim", size=(26, 2), key='sim'), sg.Button("Não", size=(26, 2), key='nao')]
        ]

        self.thrid_window = sg.Window("Sua carta está nesta página?").layout(self.layout)

        self.button, self.values = self.thrid_window.Read()

        if self.button == sg.WINDOW_CLOSED:
            return

        if self.button == 'sim':
            self.card += 4
            self.thrid_window.close()
            return

        if self.button == 'nao':
            self.thrid_window.close()
            return

    def fourth (self):
        cartas = np.array([8, 9, 10, 11, 12, 13, 14, 15])
        np.random.shuffle(cartas.T)

        self.layout = [
            [sg.Text("Sua carta está aqui?")],
            [
                sg.Image(filename="cartas/{}.png".format(cartas[0])),
                sg.Image(filename="cartas/{}.png".format(cartas[1])),
                sg.Image(filename="cartas/{}.png".format(cartas[2])),
                sg.Image(filename="cartas/{}.png".format(cartas[3])),
            ],
            [
                sg.Image(filename="cartas/{}.png".format(cartas[4])),
                sg.Image(filename="cartas/{}.png".format(cartas[5])),
                sg.Image(filename="cartas/{}.png".format(cartas[6])),
                sg.Image(filename="cartas/{}.png".format(cartas[7])),
            ],
            [sg.Button("Sim", size=(26, 2), key='sim'), sg.Button("Não", size=(26, 2), key='nao')]
        ]

        self.fourth_window = sg.Window("Sua carta está nesta página?").layout(self.layout)

        self.button, self.values = self.fourth_window.Read()

        if self.button == sg.WINDOW_CLOSED:
            return

        if self.button == 'sim':
            self.card += 8
            self.fourth_window.close()
            return

        if self.button == 'nao':
            self.fourth_window.close()
            return

    def responses (self):
        if not self.card:
            return False

        carta = "cartas-resposta/{}.png".format(self.card)
        layout = [
            [sg.Text("Sua carta é essa?")],
            [sg.Text("(👍≖‿≖)👍", size=(10, 1)), sg.Text("¯\_(ツ)_/¯", size=(10, 1))],
            [sg.Image(filename=carta)],
            [sg.Button("Sim!!!", size=(30, 3), key="sim")]
        ]

        window = sg.Window("Resposta").layout(layout)

        button, values = window.Read()

        if button in (sg.WINDOW_CLOSED, "sim"):
            window.close()
            return True

import PySimpleGUI as sg
import numpy as np
import game as gm
import error as er

class Intro:
    def __init__ (self):
        self.layout = [
            [sg.Text("Seja bem vindo!", font="Courier 50", justification="center")],
            [sg.Image(filename="cartas/logo.png")],
            [sg.Button("Iniciar", size=(37, 3), key="open"), sg.Button("Fechar", size=(37, 3), key="close")],
        ]

        self.window = sg.Window("Adivinhador", self.layout, margins=(100, 50))
    
    def show (self):
        self.button, self.values = self.window.Read()

        if self.button == sg.WINDOW_CLOSED:
            return False

        if self.button == "open":
            self.window.close()
            return True

        if self.button == "close":
            self.window.close()
            return False

def main ():
    started = Intro()

    if not started.show():
        return

    while True:
        try:
            g = gm.Game()
            g.show()

            layout = [
                [sg.Text("Deseja testar minhas habilidades de adivinhação novamente?")],
                [sg.Button("Sim", size=(21, 2), key="sim"), sg.Button("Não", size=(21, 2), key="nao")]
            ]

            window = sg.Window("Jogar novamente?", layout)

            button, values = window.Read()

            if button in (sg.WINDOW_CLOSED, "nao"):
                window.close()
                break

            if button == "sim":
                window.close()
        except:
            error = er.Error("Um erro inesperado ocorreu\nReinicie o aplicativo")
            error.show()
            

main()
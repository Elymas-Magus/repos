import PySimpleGUI as sg

class Error:
    def __init__ (self, msg_error):
        self.content = [
            [sg.Text(msg_error)],
            [sg.Image(filename='imgs/error.png', size=(220, 125), key='image')],
            [sg.OK(size=(200, 2))]
        ]

        self.window = sg.Window("Error", size=(220, 220)).layout(self.content)

    def show (self):
        self.button, self.values = self.window.Read()

        if self.button == sg.WINDOW_CLOSED:
            return

        if self.button == 'OK':
            self.window.close()
            return


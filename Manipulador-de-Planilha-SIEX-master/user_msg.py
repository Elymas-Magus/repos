import PySimpleGUI as sg


class Table:
    def __init__ (self, df_list, title = "Duplicatas"):
        self.content = self.normalize_df(df_list)

        self.layout = [
            [sg.Listbox(values=self.content, size=(940, 15))],
            [sg.Button('Remover', size=(200, 2), key='ok')]
        ]

        self.window = sg.Window(title, size=(950, 320)).layout(self.layout)

    def show (self):
        self.button, self.values = self.window.Read()


    def events (self):
        if self.button == sg.WINDOW_CLOSED:
            return

        if self.button == 'ok':
            self.window.close()
            return


    def normalize_df (self, df_list):
        p = self.first_key (df_list[0])
        j = [40, 50]

        response = ["".ljust(6, "_") + "E-mail".ljust(40, "_") + "Nome".ljust(50, "_") + "CPF"]
        for duplicata in df_list:
            for row in duplicata[p].index:
                i = 0
                temp = str(row).ljust(6, "_")
                for col in duplicata:
                    item = duplicata.loc[row, col]
                    if i < 2:
                        temp += item.ljust(j[i], "_")
                        i += 1
                    else:
                        temp += item

                response.append(temp.strip())
            response.append("".ljust(157, "*") + "\n")

        return tuple(response)

    @staticmethod
    def first_key (df_list):
        chaves = df_list.keys()
        return chaves[0]


class SuccessList:
    def __init__ (self, arr):
        self.layout = []

        for item in arr:
            if item.find('sucesso') >= 0:
                self.layout.append([sg.Text(item), sg.Image(filename='imgs/success20px.png', size=(20, 20))])
            else:
                self.layout.append([sg.Text(item), sg.Image(filename='imgs/error20px.png', size=(20, 20))])

        self.layout.append([sg.Button("OK", key="ok")])

        self.window = sg.Window("Resultado", self.layout)

    def show (self):
        self.button, self.values = self.window.Read()

        if self.button == sg.WINDOW_CLOSED:
            return
        
        if self.button == 'ok':
            self.window.close()
            return


class Success:
    def __init__ (self, msg_success):
        self.content = [
            [sg.Text(msg_success)],
            [sg.Image(filename='imgs/success.png', size=(220, 125), key='image')],
            [sg.Button('OK', size=(200, 2), key='ok')]
        ]

        self.window = sg.Window("Sucesso", size=(230, 220)).layout(self.content)

    def show (self):
        self.button, self.values = self.window.Read()

        if self.button == sg.WINDOW_CLOSED:
            return

        if self.button == 'ok':
            self.window.close()
            return


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


class WarningMsg:
    def __init__ (self, msg_success):
        self.content = [
            [sg.Text(msg_success)],
            [sg.Image(filename='imgs/warning.png', size=(220, 125), key='image')],
            [sg.Button('OK', size=(200, 2), key='ok')]
        ]

        self.window = sg.Window("Alerta", size=(230, 220)).layout(self.content)

    def show (self):
        self.button, self.values = self.window.Read()

        if self.button == sg.WINDOW_CLOSED:
            return

        if self.button == 'ok':
            self.window.close()
            return


class Question:
    def __init__ (self, msg):
        self.content = [
            [sg.Text(msg)],
            [sg.Button("Sim", size=(11, 2), key='sim'), sg.Button("Não", size=(11, 2), key='nao')]
        ]

        self.window = sg.Window ("Escolha uma opção", size=(230, 100)).layout(self.content)

    def show (self):
        self.button, self.values = self.window.Read()

        if self.button in (sg.WINDOW_CLOSED, 'sim', 'nao'):
            self.window.close()

        return self.button
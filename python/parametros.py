import re
import sys


def getParam(program):
    if "\\" not in program:
        print("Coloque duas barras.")
        sys.exit()
    else:
        program = "G:\\Meu Drive\\TOTVS\\TFS\\Fontes\\{0}".format(program)
        text = open(program, "r")

        parametros = []
        perguntas = []

        for line in text:
            line = line.upper()

            if "MV_" in line:
                pesquisa = re.search("\\bMV_.+?\\b", line, re.IGNORECASE)

                if pesquisa[0] not in parametros and pesquisa[0].find("MV_PAR") != 0:
                    parametros.append(pesquisa[0])

                if pesquisa[0] not in perguntas and pesquisa[0].find("MV_PAR") == 0:
                    perguntas.append(pesquisa[0])

        parametros.sort()
        perguntas.sort()

        print(parametros)
        # print("-"*20)
        # print(perguntas)

        text.close()


rotina = sys.argv[1]
getParam(rotina)

# Enconding UTF-8

import pyodbc
import re
import os
import pyperclip

import sys


def db_conexao():
	db_SERVER = 'SPON010104935\\SQL2014'
	db_BATABASE = 'P12125MNTDB'
	db_UID = 'sa'
	db_PWD = '1234'
	db_cnx = pyodbc.connect("DRIVER={ODBC Driver 11 for SQL Server};SERVER="+db_SERVER+";DATABASE="+db_BATABASE+";UID="+db_UID+";PWD="+db_PWD)

	# db_ODBC = 'Py' #ODBC32
	# db_cnx = pyodbc.connect("DSN="+db_ODBC)

	return db_cnx

def db_query(query):
	#Conexão com o banco
	db_cnx = db_conexao()
	#Limpa a tela
	os.system("cls")

	#Nome da tabela
	nFrom = query.upper().find("FROM")
	cSx2 = query[nFrom+5:nFrom+11]
	curX2 = db_cnx.cursor()
	cNomeTab = curX2.execute("SELECT X2_NOME FROM SX2T10 WHERE X2_ARQUIVO =?",cSx2).fetchall()[0][0].strip()
	curX2.close()
	del curX2

	#Verifica se foi encaminhado os campos da query
	cCampos = ""
	if not query.find("*") < 0:
		#Pego os campos predefinidos
		cArqSx3 = open('SX3.txt','r')
		aArqSx3 = cArqSx3.readlines()
		for cAux in aArqSx3:
			if cAux.split()[0] ==  cSx2[0:3]:
				cCampos = cAux.split()[1]
		if cCampos:
			query = query.replace("*",cCampos)

	#Executa a query	
	cur = db_cnx.cursor()
	aResults = cur.execute(query)
	#Armazena o nome das colunas da query
	aColumns = []
	for nX in range(0,len(aResults.description)):
		aColumns.append(aResults.description[nX][0])
	aResults = aResults.fetchall()
	cur.close()
	del cur

	#Pego o nome dos campos
	aSx3 =[]
	cur2 = db_cnx.cursor()
	for nX in range(0,len(aColumns)):
		cQuerySx3 =  "SELECT X3_DESCRIC FROM SX3T10 WHERE D_E_L_E_T_ ='' AND X3_CAMPO = '" + aColumns[nX] + "'"
		ret = cur2.execute(cQuerySx3).fetchall()
		aSx3.append(ret[0] if len(ret) > 0 else "")
	cur2.close()
	del cur2

	#Monta o resultado
	string = ""
	string += ("( " + cSx2 + " " + cNomeTab + " )\n\n" )
	for nX in range(0,len(aResults)):
		string += "<< Registro " + str(nX+1) + " >>\n"
		for nC in range(0,len(aResults[nX].cursor_description)):
			if not re.search(aResults[nX].cursor_description[nC][0], "D_E_L_E_T_|R_E_C_N_O_|R_E_C_D_E_L_", re.IGNORECASE):
				#if not (aResults[nX][nC].strip() if type(aResults[nX][nC])==str else aResults[nX][nC]) == "": # não imprime campos vazio
				string += ("{0:<10} = {2:<50} ({1:<30})\n".format(aResults[nX].cursor_description[nC][0]
					,aSx3[nC][0].strip(),aResults[nX][nC].strip() if type(aResults[nX][nC])==str else aResults[nX][nC]))
		string += "\n\n"

	#Disponibiliza o resultado no clipboard
	# pyperclip.copy(string)
	#Imprime em tela
	print(string)
	input()

def db_cadastros(aCadastro):

	for nY in range(0,len(aCadastro)):
		if aCadastro[nY][0] == "SA1":
			nTamFil = db_filial("SA1")
			cFil = aCadastro[nY][1][:nTamFil]
			cQuery  = "SELECT A1_FILIAL,A1_COD,A1_LOJA,A1_NOME,A1_PESSOA,A1_TIPO,A1_NROPAG,A1_NROCOM,A1_RECINSS,A1_RECPIS,A1_RECCOFI,A1_RECCSLL,A1_NATUREZ  from SA1T10 WHERE "
			cQuery += "	A1_FILIAL = '{0}' AND A1_COD='{1}' AND A1_LOJA = '{2}' AND D_E_L_E_T_ =''".format(cFil,aCadastro[nY][2],aCadastro[nY][3]) 
			db_query(cQuery)

		if aCadastro[nY][0] == "SED":
			nTamFil = db_filial("SED")
			cFil = aCadastro[nY][1][:nTamFil]
			cQuery  = "SELECT ED_FILIAL,ED_CODIGO,ED_DESCRIC,ED_CALCIRF,ED_PERCIRF,ED_CALCISS,ED_CALCCSL,ED_CALCCOF,ED_CALCPIS,ED_PERCCOF,ED_PERCCSL,ED_PERCPIS,ED_CALCINS,ED_PERCINS,ED_TIPO,ED_PAI FROM SEDT10 WHERE "
			cQuery += " ED_FILIAL = '{0}' AND ED_CODIGO ='{1}'".format(cFil,aCadastro[nY][2])
			db_query(cQuery)
	
	return

def db_filial(cTabela):

	#Conexão com o banco
	db_cnx = db_conexao()
	cur = db_cnx.cursor()
	cSX2 = cur.execute("SELECT X2_MODOEMP,X2_MODOUN,X2_MODO FROM SX2T10 WHERE X2_CHAVE ='{0}'".format(cTabela)).fetchall()
	#SIGAMAT EEUUUFFF
	nTamFil =0
	if cSX2[0][0] == "E":
		nTamFil = 2
	if cSX2[0][1] == "E":
		nTamFil += 3
	if cSX2[0][2] == "E":
		nTamFil += 3

	cur.close()
	del cur

	return nTamFil



#Entrada de dados
# cQuery = 'a'
# while cQuery:
# 	cQuery = input("Query = ")
# 	if cQuery:
# 		db_query(cQuery)

cQuery = sys.argv[1]


# cQuery = "SELECT E1_FILIAL, E1_PREFIXO, E1_NUM, E1_PARCELA, E1_TIPO, E1_CLIENTE, E1_LOJA, E1_NATUREZ, E1_PORTADO, E1_AGEDEP, E1_MOEDA, E1_VALOR, E1_VLCRUZ, E1_SALDO, E1_STATUS, E1_EMISSAO, E1_VENCTO, E1_VENCREA, E1_BAIXA, E1_IRRF, E1_ISS, E1_INSS, E1_CSLL, E1_COFINS, E1_PIS, E1_ORIGEM, E1_TITPAI, E1_NUMLIQ, E1_IDLAN, E1_CCUSTO, E1_CLVL, E1_ITEMCTA, E1_TIPOLIQ FROM SE1T10 SE1 WHERE R_E_C_N_O_ = 1"

db_query(cQuery)
# print(cQuery)


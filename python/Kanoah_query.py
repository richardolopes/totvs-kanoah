# Enconding UTF-8

import pyodbc
import re


def db_conexao():
	"""
	db_SERVER = '127.0.0.1'
	db_BATABASE = 'P12123MNTDB'
	db_UID = 'xxx'
	db_PWD = 'xxx'
	db_cnx = pyodbc.connect("DRIVER={ODBC Driver 11 for SQL Server};SERVER="+db_SERVER+";DATABASE="+db_BATABASE+";UID="+db_UID+";PWD="+db_PWD)
	"""
	db_ODBC = 'Py' #ODBC32
	db_cnx = pyodbc.connect("DSN="+db_ODBC)

	return db_cnx

def db_query(query, lCadrastros):

	#Conexão com o banco
	db_cnx = db_conexao()
	cur = db_cnx.cursor()
	
	aResults = cur.execute(query)

	aColumns = [] #Armazena o nome das colunas da query
	for nX in range(0,len(aResults.description)):
		aColumns.append(aResults.description[nX][0])

	aResults = aResults.fetchall()
	cur.close()
	del cur

	aSx3 =[]
	cur2 = db_cnx.cursor()

	for nX in range(0,len(aColumns)):
		cQuerySx3 =  "SELECT X3_DESCRIC FROM SX3T10 WHERE D_E_L_E_T_ ='' AND X3_CAMPO = '" + aColumns[nX] + "'"
		ret = cur2.execute(cQuerySx3).fetchall()
		aSx3.append(ret[0] if len(ret) > 0 else "")
	cur2.close()
	del cur2
	
	aCadastro = []

	for nX in range(0,len(aResults)):
		if lCadrastros:
			if "SE1" in query:
				cFilial = aResults[nX][aColumns.index('E1_FILIAL')]
				cCliente = aResults[nX][aColumns.index('E1_CLIENTE')]
				cLoja = aResults[nX][aColumns.index('E1_LOJA')]
				cNatureza = aResults[nX][aColumns.index('E1_NATUREZ')]
				aCadastro.append(['SA1',cFilial,cCliente,cLoja])
				aCadastro.append(['SED',cFilial,cNatureza])
		for nC in range(0,len(aResults[nX].cursor_description)):
			if not re.search(aResults[nX].cursor_description[nC][0], "R_E_C_N_O_|R_E_C_D_E_L_", re.IGNORECASE):
				if not (aResults[nX][nC].strip() if type(aResults[nX][nC])==str else aResults[nX][nC]) == "":
					arquivo.write("{0:<10} ({1:<30}) = {2}\n".format(aResults[nX].cursor_description[nC][0]
						,aSx3[nC][0],aResults[nX][nC].strip() if type(aResults[nX][nC])==str else aResults[nX][nC]))

		arquivo.write("\n")
	if lCadrastros:
		db_cadastros(aCadastro)
	return 

def db_cadastros(aCadastro):

	for nY in range(0,len(aCadastro)):
		if aCadastro[nY][0] == "SA1":
			nTamFil = db_filial("SA1")
			cFil = aCadastro[nY][1][:nTamFil]
			cQuery  = "SELECT A1_FILIAL,A1_COD,A1_LOJA,A1_NOME,A1_PESSOA,A1_TIPO,A1_NROPAG,A1_NROCOM,A1_RECINSS,A1_RECPIS,A1_RECCOFI,A1_RECCSLL,A1_NATUREZ  from SA1T10 WHERE "
			cQuery += "	A1_FILIAL = '{0}' AND A1_COD='{1}' AND A1_LOJA = '{2}' AND D_E_L_E_T_ =''".format(cFil,aCadastro[nY][2],aCadastro[nY][3]) 
			db_query(cQuery,False)

		if aCadastro[nY][0] == "SED":
			nTamFil = db_filial("SED")
			cFil = aCadastro[nY][1][:nTamFil]
			cQuery  = "SELECT ED_FILIAL,ED_CODIGO,ED_DESCRIC,ED_CALCIRF,ED_PERCIRF,ED_CALCISS,ED_CALCCSL,ED_CALCCOF,ED_CALCPIS,ED_PERCCOF,ED_PERCCSL,ED_PERCPIS,ED_CALCINS,ED_PERCINS,ED_TIPO,ED_PAI FROM SEDT10 WHERE "
			cQuery += " ED_FILIAL = '{0}' AND ED_CODIGO ='{1}'".format(cFil,aCadastro[nY][2])
			db_query(cQuery,False)
	
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

def intitulo():
	#Conexão com o banco
	db_cnxtit = db_conexao()
	
	cFilial = input("E1_FILIAL  = ")[:8]
	cPrefixo	= input("E1_PREFIXO = ")[:3]
	cNum		= input("E1_NUM     = ")[:9]
	cParcela	= input("E1_PARCELA = ")
	cTipo		= input("E1_TIPO    = ")[:3]
	
	cQuerySE1 = "SELECT * FROM SE1T10 WHERE D_E_L_E_T_ = '' AND "
	cQuerySE1 += " E1_FILIAL = '{0}' AND E1_PREFIXO = '{1}' AND E1_NUM = '{2}' AND E1_PARCELA = '{3}' AND E1_TIPO = '{4}' ".format(cFilial,cPrefixo,cNum,cParcela,cTipo)
	cur = db_cnxtit.cursor()
	if len(cur.execute(cQuerySE1).fetchall()) > 0:
		arquivo.write("<<Títulos contas a receber>>\n")
		db_query(cQuerySE1,False)
	cur.close()
	
	cQuerySE5 = "SELECT * FROM SE5T10 WHERE D_E_L_E_T_ = '' AND "
	cQuerySE5 +=" E5_FILIAL = '{0}' AND E5_PREFIXO = '{1}' AND E5_NUMERO = '{2}' AND E5_PARCELA = '{3}' AND E5_TIPO = '{4}'".format(cFilial,cPrefixo,cNum,cParcela,cTipo)
	cur = db_cnxtit.cursor()
	if len(cur.execute(cQuerySE5).fetchall()) > 0:
		arquivo.write("<<Movimentos de baixa SE5>>\n")
		db_query(cQuerySE5,False)
	cur.close()

	cQueryFK7 = "SELECT FK7T10.* FROM FK7T10 JOIN SE1T10 ON FK7_CHAVE = E1_FILIAL+'|'+E1_PREFIXO+'|'+E1_NUM+'|'+E1_PARCELA+'|'+E1_TIPO+'|'+E1_CLIENTE+'|'+E1_LOJA WHERE "
	cQueryFK7 += " E1_FILIAL = '{0}' AND E1_PREFIXO = '{1}' AND E1_NUM = '{2}' AND E1_PARCELA = '{3}' AND E1_TIPO = '{4}' ".format(cFilial,cPrefixo,cNum,cParcela,cTipo)
	cur = db_cnxtit.cursor()
	if len(cur.execute(cQueryFK7).fetchall()) > 0:
		arquivo.write("<<IDDOC Tabela FK7>>\n")
		db_query(cQueryFK7,False)
	cur.close()
	
	cur = db_cnxtit.cursor()
	cIdDoc = cur.execute(cQueryFK7).fetchall()[0][1]
	cur.close()

	#Valores Acessórios
	cQueryFKD = "SELECT * FROM FKDT10 WHERE FKD_IDDOC ='{}'".format(cIdDoc)
	#CADASTROS INI
	cur = db_cnxtit.cursor()
	aFKD = cur.execute(cQueryFKD).fetchall()
	cur.close()
	aFKC = []
	for nX in range(0,len(aFKD)):
		aFKC.append(aFKD[nX][1])
	nTamFilFKC = db_filial("FKC")

	for nX in range(0,len(aFKC)):
		if nX == 0:
			arquivo.write("<<Valor Acessório Cadastro>>\n")
		cQueryFKC = "SELECT * FROM FKCT10 WHERE FKC_FILIAL ='{0}' AND FKC_CODIGO ='{1}' AND D_E_L_E_T_ =''".format(cFilial[:nTamFilFKC],aFKC[nX])
		db_query(cQueryFKC,False)
	#CADASTROS FIM
	cur = db_cnxtit.cursor()
	if len(cur.execute(cQueryFKD).fetchall()) > 0:	
		arquivo.write("<<Valor Acessório do Título>>\n")
		db_query(cQueryFKD,False)
	cur.close()
	
	return


#Abre o arquivo de texto
arquivo = open('kanoah.txt','w')
cArqQuery = open('Query.txt','r')

intitulo()
"""
cOpc = input("1 - Só query \n2 - Com cadastros\n")
if "2" in cOpc :
	lCadastros = True
else:
	lCadastros = False

aLinQuery = cArqQuery.readlines()
for nLin in range(0,len(aLinQuery)):
	db_query(aLinQuery[nLin],lCadastros)
"""

cArqQuery.close()
arquivo.close()


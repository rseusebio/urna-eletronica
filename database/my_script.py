import json
import os

def read_politics(file_name: str) -> None:
    strs = []
    
    with open(file_name, 'r') as f:
        data: dict = json.load(f)
        
        for v in data.values():
            titulo = v["titulo"]
            canditados = v["candidatos"]
            for id, obj in canditados.items():
                vice = obj["vice"] if "vice" in obj.keys() else {}
                insert_str = """INSERT INTO Politicos (ID, Titulo, Nome, Partido, Foto, Votos, Vice) VALUES ({0}, '{1}', '{2}', '{3}', '{4}', {5}, '{6}');"""\
                    .format(id, titulo, obj["nome"], obj["partido"], obj["foto"], "0", json.dumps(vice))\
                    .strip()\
                    .strip('\n')

                strs.append(insert_str)
    
    return '\n'.join(strs)
                
if __name__ == "__main__":
    with open(os.path.abspath("./create_all.sql"), "w") as f:
        data = read_politics(os.path.abspath("./politicos.json"))
        f.write("use MYSQL_DATABASE;\n")
        f.write("CREATE TABLE Politicos (ID INT, Titulo VARCHAR(255), Nome VARCHAR(255), Partido VARCHAR(255), Foto VARCHAR(255), Votos INT, Vice LONGTEXT);\n")
        f.write("INSERT INTO Politicos (ID, Titulo, Nome, Partido, Foto, Votos, Vice) VALUES (0, 'prefeito', 'BRANCO', '', '', 0, '');\n")
        f.write("INSERT INTO Politicos (ID, Titulo, Nome, Partido, Foto, Votos, Vice) VALUES (0, 'vereador', 'BRANCO', '', '', 0, '');\n")
        f.write("INSERT INTO Politicos (ID, Titulo, Nome, Partido, Foto, Votos, Vice) VALUES (-1, 'prefeito', 'NULO', '', '', 0, '');\n")
        f.write("INSERT INTO Politicos (ID, Titulo, Nome, Partido, Foto, Votos, Vice) VALUES (-1, 'vereador', 'NULO', '', '', 0, '');\n")
        f.write(data + "\n")
        f.write("CREATE TABLE Eleicao (ID INT, Status BOOLEAN);\n")
        f.write("INSERT INTO Eleicao (ID, Status) VALUES (0, true);\n")
        

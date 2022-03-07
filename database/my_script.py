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
                print(id, obj)
                insert_str = """INSERT INTO Politicos (ID, titulo, Nome, Partido, Foto, Votos) VALUES ({0}, '{1}', '{2}', '{3}', '{4}', {5});"""\
                .format(id, titulo, obj["nome"], obj["partido"], obj["foto"], "0")\
                    .strip()\
                        .strip('\n')

                strs.append(insert_str)
    
    return '\n'.join(strs)
                
if __name__ == "__main__":
    with open(os.path.abspath("./create_all.sql"), "w") as f:
        data = read_politics(os.path.abspath("./politicos.json"))
        f.write("use MYSQL_DATABASE;\n")
        f.write("CREATE TABLE Politicos (ID int, titulo varchar(255), Nome varchar(255), Partido varchar(255), Foto varchar(255), Votos int);\n")
        f.write(data)

import Table from "./Table";
import Form from "./Button";

/**
 * Pagina Principal do backoffice
 * contem as tabelas e o form com os botões
 * de controle da eleicao
 * @constructor
 * @returns - Um elemento JSX
 */
export default function App() {
  return (
    <div className="App">
      <div>
        <h2>Configurações da eleição</h2>

        <Form />

        <h2>Tabelas de Votos</h2>

        <Table />
      </div>

    </div>
  );
}
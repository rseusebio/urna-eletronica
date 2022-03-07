import './App.css';
import Table from "./Table";
import Form from "./Button";

function App() {
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

export default App;

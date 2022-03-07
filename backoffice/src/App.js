import logo from './logo.svg';
import './App.css';
import Table from "./Table";
import Form from "./Button";

function App() {
  return (
    <div className="App">
      {/* <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
        <p>
          Edit <code>src/App.js</code> and save to reload.
        </p>
        <a
          className="App-link"
          href="https://reactjs.org"
          target="_blank"
          rel="noopener noreferrer"
        >
          Learn React
        </a>
      </header> */}
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

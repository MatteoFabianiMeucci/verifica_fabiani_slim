import './App.css';
import {useState} from 'react';
import ScuoleTable from './ScuoleTable';
function App() {

  const [scuole, setScuole] = useState([]);
  const [loading, setLoading] = useState(false);
  const [inserimento, setInserimento] = useState(false);
  const [nome, setNome] = useState("");
  const [err, setErr] = useState("");
  const [indirizzo, setIndirizzo] = useState("");

  async function caricaScuole(){
    setLoading(true);
    const data = await fetch("http://localhost:8080/scuole", {method:"GET"});
    const mieiDati = await data.json();
    setLoading(false);
    setScuole(mieiDati);
  }

  async function salvaScuola(){
    if(nome === "" || indirizzo === ""){
      setErr("Tutti i campi sono obbligatori");
      return;
    }
    const data = await fetch("http://localhost:8080/scuole", {
      method:"POST",
      headers:{"Content-Type": "application/json"},
      body: JSON.stringify({"nome": nome, "indirizzo": indirizzo})
    });
    setErr("");
    setNome("");
    setIndirizzo("");
    caricaScuole();
  }

  //curl -X POST http://locahost:8080/scuole -H "Content-Type: application/json" -d '{"nome": "Peano", "indirizzo": "Piazza la bomba e scappa"}'

  return (
    <div className="App">
      {scuole.length > 0 && !loading ? (
        <div>
          <ScuoleTable myArray={scuole} caricaScuole={caricaScuole} />
          {inserimento ? (
            <div>
              <h5>nome:</h5>
              <input type = "text" onChange={(e) => setNome(e.target.value)} ></input>
              <h5>indirizzo:</h5>
              <input type = "text" onChange={(e) => setIndirizzo(e.target.value)} />
              {err !== "" && <div>{err}</div>}
              <br />
              <button onClick={salvaScuola}>salva</button>
              <br />
              <button onClick={() => setInserimento(false)}>annulla</button>
            </div>
          ) : (
            <button onClick={() => setInserimento(true)}>Inserisci nuovo alunno</button>
          )}
        </div>
      ) : (
        <div>
        {loading ? (
          <div>Caricamento in corso...</div>
        ) : (
        <button onClick={caricaScuole}>carica scuole </button>
        )}
        </div>
      )
      }
    </div>
  );
}

export default App;

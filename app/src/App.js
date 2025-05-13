import './App.css';
import {useState} from 'react';
import ScuoleTable from './ScuoleTable';
function App() {

  const [scuole, setScuole] = useState([]);
  const [loading, setLoading] = useState(false);

  async function caricaScuole(){
    setLoading(true);
    const data = await fetch("http://localhost:8080/scuole", {method:"GET"});
    const mieiDati = await data.json();
    setLoading(false);
    setScuole(mieiDati);
  }

  return (
    <div className="App">
      {scuole.length > 0 && !loading ? (
        <ScuoleTable myArray={scuole} caricaScuole={caricaScuole} />
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

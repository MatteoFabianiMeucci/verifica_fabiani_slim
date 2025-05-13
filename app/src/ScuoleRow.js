import {useState} from 'react';
export default function ScuoleRow(props){
    const s = props.scuola;
    const caricaScuole = props.caricaScuole;
    const [isDeleting, setDeleting] = useState(false);
    function deleteScuola(){
        fetch("http://localhost:8080/scuole/" + s.id, {method:"DELETE"});
        caricaScuole();
    }
    return(
        <tr> 
            <td>{s.id}</td>
            <td>{s.nome}</td>
            <td>{s.indirizzo}</td>
            <td>
                {isDeleting ? (
                    <>
                    <h5>Sei sicuro?</h5>
                    <button onClick={deleteScuola}>si</button>
                    <button onClick={() => setDeleting(false)}>no</button>
                    </>
                ) : (
                    <button onClick={() => setDeleting(true)}>elimina</button>
                    )
                }
            </td>
        </tr>
    )
}
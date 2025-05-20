import {useState} from 'react';
export default function ScuoleRow(props){
    const s = props.scuola;
    const caricaScuole = props.caricaScuole;
    const [isDeleting, setDeleting] = useState(false);
    const [isEditing, setIsEditing] = useState(false);
    const [nome, setNome] = useState("");
    const [indirizzo, setIndirizzo] = useState("");
    const [err, setErr] = useState("");

    function deleteScuola(){
        fetch("http://localhost:8080/scuole/" + s.id, {method:"DELETE"});
        caricaScuole();
    }

    async function updateScuola(){
        if(nome === "" || indirizzo === ""){
            setErr("Tutti i campi sono obbligatori");
            return;
          }
        await fetch("http://localhost:8080/scuole", {
            method:"PUT",
            headers:{"Content-Type": "application/json"},
            body: JSON.stringify({"nome": nome, "indirizzo": indirizzo})
          });
        setErr("");
        setNome("");
        setIndirizzo("");
        caricaScuole();
    }
    return(
        <tr> 
            <td>{s.id}</td>
            {isEditing ? (
                <>
                    <td>
                        <input type = "text" onChange={(e) => setNome(e.target.value)} />
                    </td>
                    <td>
                        <input type = "text" onChange={(e) => setIndirizzo(e.target.value)} />
                    </td>
                    <td>
                    <button onClick={updateScuola}>save</button>
                    <button onClick={() => setIsEditing(false)}>cancel</button>
                    {err !== "" && <div>{err}</div>}
                    </td>
                </>
            ) : (
                <>
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
                        <>
                        <button onClick={() => setDeleting(true)}>elimina</button>
                        <button onClick={() => setIsEditing(true)}>edit</button>
                        </>
                    )
                    }
                </td>
                </>
            )}
        </tr>
    )
}
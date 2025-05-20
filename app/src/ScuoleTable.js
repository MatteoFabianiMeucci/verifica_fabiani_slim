import ScuoleRow from "./ScuoleRow";
import {useState} from 'react';
export default function ScuoleTable(props){
    const scuole = props.myArray;
    const caricaScuole = props.caricaScuole;
    return(
        <table border = "1">
            <tbody>
                <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Indirizzo</th>
                <th></th>
                </tr>
                {scuole.map(s => 
                    <ScuoleRow scuola={s} key={s.id} caricaScuole={caricaScuole} />
                    )}
            </tbody>
        </table>
    )
}
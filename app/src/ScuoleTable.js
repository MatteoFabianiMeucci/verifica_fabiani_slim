import ScuoleRow from "./ScuoleRow";
import {useState} from 'react';
export default function ScuoleTable(props){
    const scuole = props.myArray;
    const caricaScuole = props.caricaScuole;
    return(
        <table border = "1">
          {scuole.map(s => 
            <ScuoleRow scuola={s} caricaScuole={caricaScuole} />
            )}
        </table>
    )
}
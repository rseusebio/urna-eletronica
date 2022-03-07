import React, { useEffect, useState } from "react";
import { Button } from "@mui/material";
import axios from "axios";
import { getURL } from './utils';

/**
 * Representa o status da eleicao
 * pode ser aberta ou fechada
 * @constructor
 * @returns Um elemento JSX
 */
function StatusEleicao() {
    const [error, setError] = useState(null);
    const [items, setItems] = useState(null);

    useEffect(() => {
        const url = getURL() + "/status";

        axios.get(url, { validateStatus: _ => true })
            .then(
                (result) => {
                    console.log("status", result.data, result.status, result.statusText);
                    setItems(result.data);
                }
            )
            .catch(err => {
                setError(err);
            })
    }, []);

    if (error) {
        return <div>Error: {error.message}</div>;
    } else if (!items) {
        return <div>Loading...</div>;
    }

    return (
        <div>
            <h2>Status das eleições: <span style={{ color: items.status ? "green" : "red" }}> {items.text}</span> </h2>
        </div>
    )
}

/**
 * Retona uma função que chama um endpoint
 * depois que o endpoint é chamado a página é atualizada
 * @param {string} route - a rota para o endpoint
 * @returns - função assincrona que chama o endpoint passado
 */
const handleButton = (route) => {
    const f = async () => {
        axios.get(getURL() + route, { validateStatus: _ => true })
            .then(r => {
                console.log("button response", r);

                window.location.reload();
            });
    }

    return f;
}

/**
 * Formulário com os botões de controle da eleicao
 * Os botões são de zerar a eleicao, encerrá-la 
 * ou abrí-la novamente.
 * @returns Um elemento JSX
 */
export default function Form() {
    const style = {
        minHeight: "300px",
        backgroundColor: "#e7ebf0",
        display: "flex",
        flexDirection: "column",
        flexContent: "space-around",
        alignItems: "flex-start",
        margin: "0px",
        paddingLeft: "50px",
        // border: "1px solid black"
    }

    return (
        <div style={style}>
            <StatusEleicao />

            <Button
                variant="contained"
                color="warning"
                onClick={handleButton("/reset")}>
                Zerar Eleição
            </Button>
            <br />
            <Button
                variant="contained"
                color="error"
                onClick={handleButton("/close")}>
                Encerrar Eleição
            </Button>
            <br />
            <Button
                variant="contained"
                color="success"
                onClick={handleButton("/open")}>
                Abrir Eleição
            </Button>
            <br />
        </div>
    )
}
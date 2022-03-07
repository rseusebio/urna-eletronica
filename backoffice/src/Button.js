import React, { useEffect, useState } from "react";
import { Button } from "@mui/material";
import axios from "axios";
import { getURL } from './utils';

function StatusEleicao() {
    const [error, setError] = useState(null);
    const [items, setItems] = useState(null);

    const url = getURL() + "/status";

    useEffect(() => {
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


function Form() {
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

export default Form;
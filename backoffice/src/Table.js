import * as React from 'react';
import { useState, useEffect } from 'react';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import axios from "axios";
import { getURL } from './utils';


function PoliticoTabela(props) {

    console.log("prefeitos: ", props);
    const { data } = props;

    return (
        <TableContainer component={Paper} style={{ border: "1px solid color" }}>
            <Table sx={{ maxWidth: 650 }} aria-label="simple table">
                <TableHead>
                    <TableRow>
                        <TableCell>ID</TableCell>
                        <TableCell align="right">Nome</TableCell>
                        {/* <TableCell align="right">Titulo</TableCell> */}
                        <TableCell align="right">Partido</TableCell>
                        <TableCell align="right">Votos</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {data.map((row) => (
                        <TableRow
                            key={row.ID}
                            sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                        >
                            <TableCell component="th" scope="row">
                                {row.ID}
                            </TableCell>
                            <TableCell align="right">{row.Nome}</TableCell>
                            {/* <TableCell align="right">{row.Titulo}</TableCell> */}
                            <TableCell align="right">{row.Partido}</TableCell>
                            <TableCell align="right">{row.Votos}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </TableContainer >
    );
}

function Tabelas(params) {

    const [error, setError] = useState(null);
    // const [isLoaded, setIsLoaded] = useState(false);
    const [items, setItems] = useState(null);

    const url = getURL() + "/vote";

    useEffect(() => {
        axios.get(url, { validateStatus: _ => true })
            .then(
                (result) => {
                    console.log("done", result);
                    // setIsLoaded(true);
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
    } else {

        const style = {
            backgroundColor: "#e7ebf0",
            display: "flex",
            flexDirection: "column",
            flexContent: "center",
            alignItems: "flex-start",
            margin: "0px",
            paddingLeft: "50px"
        }

        const style2 = {
            heigth: "200px",
            width: "500px",
            margin: "0px",
            padding: "0px"
        }

        return (
            <div style={style}>

                <h3>Vereadores</h3>
                <div style={style2}>
                    <PoliticoTabela data={items.vereadores} />
                </div>

                <br />

                <h3>Prefeitos</h3>
                <div style={style2}>
                    <PoliticoTabela data={items.prefeitos} />
                </div>

                <br />
                <br />
                <br />
            </div>
        );
    }
}

export default Tabelas;
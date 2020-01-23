import React from 'react'
import styled from  'styled-components';
import Sidebar from './Sidebar';
import { useHistory, useParams } from "react-router-dom";

export const Grid = styled.div`
    display: grid;
    grid-template-columns: 280px auto;
    ${props => props.top ? "background: #181717;" :  null}
    ${props => props.top ? "border-bottom: #707070 1px solid;" :  null}
    ${props => props.top ? "min-height: 80px;" :  null}
`
export const Block = styled.div`
    background:  #121212;
    min-height: 100vh;
    color: #fff;
`

export const Logo = styled.h5`
    margin: auto 15px;

`

export const ShortCuts = styled.div`
    margin: auto 30px;
    display: flex;
    padding-right: 15px;
`


export default function index(props) {

    let history = useHistory();
    let data = useParams();
    
    return (
        <Block>
            <Grid top>
                <Logo>
                    Krishna
                </Logo>
                <ShortCuts>
                    <props.header/>
                </ShortCuts>
            </Grid>
            <Grid>
                <Sidebar/>
                <props.content data={data} history={history}/>
            </Grid>
        </Block>
    )
}

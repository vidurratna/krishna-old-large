import React from 'react'

import styled from  'styled-components';

const Holder = styled.div`
    display: block;
`

const Line = styled.div`
    height: 8px;
    background: #02001e;
    top: 22px;
    width: 80%;
    position: relative;
`

const BallHolder = styled.div`
    display: flex;
    justify-content: space-between;
    width: 80%;
`

const Ball = styled.div`
    background: ${props => props.error ? "#e21818" : props.selected ? "#55514e" : "#fff"};
    color: ${props => props.error ? "#fff" : props.selected ? "#fff" : "#55514e"};
    border: 3px solid #55514e;
    width: 30px;
    display: flex;
    transition: 0.3s;
    height: 30px;
    border-radius: 47px;

    cursor: pointer;

    z-index: 5;

    &:hover {
        background: ${props => props.selected ? "#a9866c" : "#55514e"};
        color: #fff;
    }

    & h2 {
        margin: auto;
    }
`

export default function PageSelect(props) {
    return (
        <Holder>
            <Line/>
            <BallHolder>
                <Ball error={props.error.page1} onClick={() => props.change(1)} selected={props.page === 1} ><h2>1</h2></Ball>
                <Ball error={props.error.page2} onClick={() => props.change(2)} selected={props.page === 2} ><h2>2</h2></Ball>
                <Ball error={props.error.page3} onClick={() => props.change(3)} selected={props.page === 3} ><h2>3</h2></Ball>
            </BallHolder>
        </Holder>
    )
}

import React, { Component } from 'react'

import styled from  'styled-components';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { device } from '../../constants';


const Holder = styled.div`
    display: flex;
    flex-direction: column;
    
    & svg {
        transition: 0.3s;
        color:${props => props.focus ? "#21a1a6" : props.error ? "#e21818" : "#514026"};
    }
`

const Label = styled.label`
    position: relative;
    left: 70px;
    color: ${props => props.settings.focus ? "#21a1a6" : props.error ? "#e21818" : "#514026"};
    top: ${props => props.settings.top};
    width: fit-content;
    cursor: text;
    line-height: 22px;
    font-size: ${props => props.settings.small ? "12px" : "22px"};
    transition: 0.3s;

    
    animation-timing-function: ease-in-out;


    @media ${device.laptop} {
        font-size: ${props => props.settings.small ? "8px" : "18px"};
    }

    @media ${device.tablet} {
        font-size: ${props => props.settings.small ? "8px" : "18px"};
    }

`

const Icon = styled(FontAwesomeIcon)`
    position: relative;
    left: 28px;
    top: 57px;
    font-size: 22px;
    cursor: text;
`

const InputDevice = styled.input`
    border: 4px solid ${props => props.settings.focus ? "#21a1a6" : props.error ? "#e21818" : "#6f6f6f"};
    color: #514026;
    padding: 30px 10px 25px 65px;
    border-radius: 7px;
    transition: 0.3s;
    background: #ffffff;
    font-size: 22px;

    &:hover {
        background: #e4d5bf;
    }

    @media ${device.laptop} {
        font-size: 18px;
    }

    @media ${device.tablet} {
        font-size: 12px;
    }

    
`

export default class IconInput extends Component {

    constructor(props) {
        super(props);
        this.textInput = React.createRef();
        this.state = {
            text: "",
            settings: {
                small: false,
                focus: false,
                top:  "78px",
            }
        };

        this.handleChange = this.handleChange.bind(this);
    }

    handleFocus() {
        this.textInput.current.focus();
        this.setState({settings: {
            small: true,
            focus: true,
            top:  "60px"
        }})
    }

    handleBlur() {
        if(this.state.text <= 0){
            this.setState({settings: {
                small: false,
                focus: false,
                top:  "78px"
            }})
        } else {
            this.setState({settings: {
                ...this.state.settings,
                small: true,
                focus: false,
                top:  "60px"
            }})
        }

        
    }

    handleChange(event) {
        this.setState({text: event.target.value});
        this.props.onChange(event);
    }

    render() {
        return (
            <Holder focus={this.state.settings.focus} error={this.props.error} >
                <Label 
                    settings={this.state.settings} 
                    onClick={() => this.handleFocus()} 
                    error={this.props.error}
                    >{this.props.label}
                </Label>
                <Icon
                    icon={this.props.icon}
                    onClick={() => this.handleFocus()} 
                />
                <InputDevice 
                    id={this.props.id || "email"}
                    name={this.props.name }
                    type={this.props.type || "text"}
                    settings={this.state.settings} 
                    onChange={this.handleChange} 
                    error={this.props.error}
                    onBlur={()=>this.handleBlur()} 
                    onFocus={()=> this.handleFocus()} 
                    ref={this.textInput}
                />
        </Holder>
        )
    }
}

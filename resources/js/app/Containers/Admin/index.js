import React, { Component } from 'react'

export default class AdminPage extends Component {

    constructor(props) {
        super(props);

        this.state = { hideSidebar: false };

        this.handleSidebar = this.handleSidebar.bind(this);
    }

    handleSidebar() {
        this.setState({
            hideSidebar:  !this.state.hideSidebar
        });
    }

    render() {
        return (
            <div>
                <div>
                    <div>

                    </div>
                    {this.props.header}
                </div>
                <div>
                    <div>

                    </div>
                    {this.props.content}
                </div>
            </div>
        )
    }
}

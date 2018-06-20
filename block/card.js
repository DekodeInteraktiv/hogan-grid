import React, { Component } from 'react';
import ReactHtmlParser, { processNodes, convertNodeToElement, htmlparser2 } from 'react-html-parser';

class Card extends Component {
	constructor(props){
		super(props);

		this.state = {
			post: 0,
			html: '<div>test</div>'
		}
	}

	render() {
		let output = this.props.html;
		if( this.props.noLink) {
			output = output.replace("href", "data-href");
		}
		return (
			<div className={"hogan-grid-block"}>
			{ReactHtmlParser(output)}
			</div>
		);
	}
}

export default Card;

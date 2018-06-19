/**
* BLOCK: Basic with ESNext
*
* Registering a basic block with Gutenberg.
* Simple block, renders and saves the same content without any interactivity.
*
* Using inline styles - no external stylesheet needed.  Not recommended!
* because all of these styles will appear in `post_content`.
*/

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

const el = wp.element.createElement;
const BlockControls = wp.editor.BlockControls;
const AlignmentToolbar = wp.editor.BlockAlignmentToolbar;
const UrlInput = wp.editor.UrlInput;

/**
* Register Basic Block.
*
* Registers a new block provided a unique name and an object defining its
* behavior. Once registered, the block is made available as an option to any
* editor interface where blocks are implemented.
*
* @param  {string}   name     Block name.
* @param  {Object}   settings Block settings.
* @return {?WPBlock}          The block, if it has been successfully
*                             registered; otherwise `undefined`.
*/
registerBlockType( 'hogan-grid/cards', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Card(s)', 'hogan-grid' ), // Block title.
	icon: 'screenoptions', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	attributes: {
		alignment: {
			type: 'string',
		},
		size: {
			type: 'string',
		},
	},
	getEditWrapperProps( attributes ) {
		if ( attributes.alignment === 'left' || attributes.alignment === 'right' ) {
			return { 'data-align': attributes.alignment };
		}
	},
	// The "edit" property must be a valid function.
	edit: function( props ) {
		const alignment = props.attributes.alignment;

		fetch( '/wp-json/wp/v2/posts/7', {
				method: 'GET'
			} )
			.then(res => res.json())
			.then(response =>  {
				console.log(response);
			});

		function onChangeAlignment( newAlignment ) {
			props.setAttributes( { alignment: newAlignment } );

			let size;
			switch (newAlignment) {
				case 'wide':
					size = 'medium';
					break;
				case 'full':
					size = 'large';
					break;
				default:
					size = 'small';

			}
			props.setAttributes( { size: size } );
		}

		return [
			el(
				BlockControls,
				{ key: 'controls' },
				el(
					AlignmentToolbar,
					{
						value: alignment,
						onChange: onChangeAlignment
					}
				),
			),
			<div className={ "hogan-grid hogan-grid-block" }>
			<div className={ "hogan-grid-item hogan-grid-item-size-" + props.attributes.size + " hogan-grid-item-type-post savage-has-image savage-has-label savage-has-heading savage-has-excerpt savage-has-teaser" }>
			<div className="hogan-grid-item-inner">
			<div className="savage-card-image">
			<div className="savage-card-image-inner">
			<span className="savage-card-image-image" style={{backgroundImage:'url(' + 'http://teft.local/wp-content/uploads/2018/06/hyper_beast-wallpaper-3440x1440-768x321.jpg' + ')'}}></span>	</div>
			</div>
			<div className="savage-card-body">
			<div className="savage-card-body-inner">
			<div className="savage-card-label-holder">
			<p className="savage-card-label">Post</p>
			</div>
			<h2 className="savage-card-heading">This is a card</h2>
			<p className="savage-card-excerpt">Look at this card, this card is amazing</p>
			<p className="savage-card-teaser">Read more about cards</p>
			</div>
			</div>
			<a className="savage-card-link"><span className="screen-reader-text">Read article "Test2"</span></a></div>
			</div>
			</div>
		];
	},

	// The "save" property must be specified and must be a valid function.
	save: function( props ) {
		return (
			<div className={ "align-" + props.attributes.alignment + " hogan-grid hogan-grid-block" }>
			<div className="hogan-grid-item hogan-grid-item-size-small hogan-grid-item-type-post savage-has-image savage-has-label savage-has-heading savage-has-excerpt savage-has-teaser">
			<div className="hogan-grid-item-inner">
			<div className="savage-card-image">
			<div className="savage-card-image-inner">
			<span className="savage-card-image-image" style={{backgroundImage:'url(' + 'http://teft.local/wp-content/uploads/2018/06/hyper_beast-wallpaper-3440x1440-768x321.jpg' + ')'}}></span>	</div>
			</div>
			<div className="savage-card-body">
			<div className="savage-card-body-inner">
			<div className="savage-card-label-holder">
			<p className="savage-card-label">Post</p>
			</div>
			<h2 className="savage-card-heading">This is a card</h2>
			<p className="savage-card-excerpt">Look at this card, this card is amazing</p>
			<p className="savage-card-teaser">Read more about cards</p>
			</div>
			</div>
			<a className="savage-card-link"><span className="screen-reader-text">Read article "Test2"</span></a></div>
			</div>
			</div>
		);
	},
} );

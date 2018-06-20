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

const TextControl = wp.editor.TextControl;

import Card from './card.js';

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
		post: {
			type: 'integer',
		},
		search: {
			type: 'string',
		},
		postList: {
			type: 'array',
		},
		output: {
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
		const size = (props.attributes.size ? props.attributes.size : 'small');
		const post = props.attributes.post;
		const alignment = props.attributes.alignment;
		const search = props.attributes.search;
		const postList = props.attributes.postList;

		function getPost( postID, sizeString ) {
			sizeString = (sizeString ? sizeString : size);
			fetch( '/wp-json/hogan/grid/get?post=' + postID + '&size=' + sizeString, {
				method: 'GET'
			} )
			.then(res => res.json())
			.then(response =>  {
				console.log(response);
				props.setAttributes( {
					output: response.data
				} );
			});
		}

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
			getPost( post, size );
		}

		function onSearchPost( newPost ) {
			const value = newPost.target.value;
			fetch( '/wp-json/wp/v2/posts?search=' + value, {
					method: 'GET'
				} )
				.then(res => res.json())
				.then(response =>  {
					if( value ) {
						props.setAttributes( { postList: response } );
					} else {
						props.setAttributes( { postList: false } );
					}
				});
			props.setAttributes( { search: newPost.target.value } );
		}

		function onChangePost( newPost ) {
			const search = newPost.target.dataset.title;
			const post = parseInt( newPost.target.dataset.post, 10 );
			props.setAttributes( {
				search: search,
				postList: false,
				post: post,
			} );
			getPost( post );
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
				el(
					'input',
					{
						value: search,
						onChange: onSearchPost
					}
				),
				<div style={{position:'absolute', right: '0', width: '193px', background: '#fff', top: '100%', border: '1px solid #ddd'}}>
				{postList && postList.map((post, index) =>
					<a data-post={post.id} data-title={post.title.rendered} style={{cursor: 'pointer', display:'block', borderBottom: '1px solid #ddd', fontSize: '14px', padding: '2px 4px'}} onClick={onChangePost}>{post.title.rendered}</a>
				)}
				</div>
			),
			<Card noLink={true} html={props.attributes.output} />
		];
	},

	// The "save" property must be specified and must be a valid function.
	save: function( props ) {
		return (
			<div className={"hogan-grid-align-" + props.attributes.alignment}><Card html={props.attributes.output} /></div>
		);
	},
} );

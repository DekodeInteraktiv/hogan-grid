/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

/**
* BLOCK: Basic with ESNext
*
* Registering a basic block with Gutenberg.
* Simple block, renders and saves the same content without any interactivity.
*
* Using inline styles - no external stylesheet needed.  Not recommended!
* because all of these styles will appear in `post_content`.
*/

var __ = wp.i18n.__; // Import __() from wp.i18n

var registerBlockType = wp.blocks.registerBlockType; // Import registerBlockType() from wp.blocks

var el = wp.element.createElement;
var BlockControls = wp.editor.BlockControls;
var AlignmentToolbar = wp.editor.BlockAlignmentToolbar;
var UrlInput = wp.editor.UrlInput;

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
registerBlockType('hogan-grid/cards', { // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __('Card(s)', 'hogan-grid'), // Block title.
	icon: 'screenoptions', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	attributes: {
		alignment: {
			type: 'string'
		},
		size: {
			type: 'string'
		}
	},
	getEditWrapperProps: function getEditWrapperProps(attributes) {
		if (attributes.alignment === 'left' || attributes.alignment === 'right') {
			return { 'data-align': attributes.alignment };
		}
	},

	// The "edit" property must be a valid function.
	edit: function edit(props) {
		var alignment = props.attributes.alignment;

		fetch('/wp-json/wp/v2/posts/7', {
			method: 'GET'
		}).then(function (res) {
			return res.json();
		}).then(function (response) {
			console.log(response);
		});

		function onChangeAlignment(newAlignment) {
			props.setAttributes({ alignment: newAlignment });

			var size = void 0;
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
			props.setAttributes({ size: size });
		}

		return [el(BlockControls, { key: 'controls' }, el(AlignmentToolbar, {
			value: alignment,
			onChange: onChangeAlignment
		})), wp.element.createElement(
			'div',
			{ className: "hogan-grid hogan-grid-block" },
			wp.element.createElement(
				'div',
				{ className: "hogan-grid-item hogan-grid-item-size-" + props.attributes.size + " hogan-grid-item-type-post savage-has-image savage-has-label savage-has-heading savage-has-excerpt savage-has-teaser" },
				wp.element.createElement(
					'div',
					{ className: 'hogan-grid-item-inner' },
					wp.element.createElement(
						'div',
						{ className: 'savage-card-image' },
						wp.element.createElement(
							'div',
							{ className: 'savage-card-image-inner' },
							wp.element.createElement('span', { className: 'savage-card-image-image', style: { backgroundImage: 'url(' + 'http://teft.local/wp-content/uploads/2018/06/hyper_beast-wallpaper-3440x1440-768x321.jpg' + ')' } }),
							' '
						)
					),
					wp.element.createElement(
						'div',
						{ className: 'savage-card-body' },
						wp.element.createElement(
							'div',
							{ className: 'savage-card-body-inner' },
							wp.element.createElement(
								'div',
								{ className: 'savage-card-label-holder' },
								wp.element.createElement(
									'p',
									{ className: 'savage-card-label' },
									'Post'
								)
							),
							wp.element.createElement(
								'h2',
								{ className: 'savage-card-heading' },
								'This is a card'
							),
							wp.element.createElement(
								'p',
								{ className: 'savage-card-excerpt' },
								'Look at this card, this card is amazing'
							),
							wp.element.createElement(
								'p',
								{ className: 'savage-card-teaser' },
								'Read more about cards'
							)
						)
					),
					wp.element.createElement(
						'a',
						{ className: 'savage-card-link' },
						wp.element.createElement(
							'span',
							{ className: 'screen-reader-text' },
							'Read article "Test2"'
						)
					)
				)
			)
		)];
	},

	// The "save" property must be specified and must be a valid function.
	save: function save(props) {
		return wp.element.createElement(
			'div',
			{ className: "align-" + props.attributes.alignment + " hogan-grid hogan-grid-block" },
			wp.element.createElement(
				'div',
				{ className: 'hogan-grid-item hogan-grid-item-size-small hogan-grid-item-type-post savage-has-image savage-has-label savage-has-heading savage-has-excerpt savage-has-teaser' },
				wp.element.createElement(
					'div',
					{ className: 'hogan-grid-item-inner' },
					wp.element.createElement(
						'div',
						{ className: 'savage-card-image' },
						wp.element.createElement(
							'div',
							{ className: 'savage-card-image-inner' },
							wp.element.createElement('span', { className: 'savage-card-image-image', style: { backgroundImage: 'url(' + 'http://teft.local/wp-content/uploads/2018/06/hyper_beast-wallpaper-3440x1440-768x321.jpg' + ')' } }),
							' '
						)
					),
					wp.element.createElement(
						'div',
						{ className: 'savage-card-body' },
						wp.element.createElement(
							'div',
							{ className: 'savage-card-body-inner' },
							wp.element.createElement(
								'div',
								{ className: 'savage-card-label-holder' },
								wp.element.createElement(
									'p',
									{ className: 'savage-card-label' },
									'Post'
								)
							),
							wp.element.createElement(
								'h2',
								{ className: 'savage-card-heading' },
								'This is a card'
							),
							wp.element.createElement(
								'p',
								{ className: 'savage-card-excerpt' },
								'Look at this card, this card is amazing'
							),
							wp.element.createElement(
								'p',
								{ className: 'savage-card-teaser' },
								'Read more about cards'
							)
						)
					),
					wp.element.createElement(
						'a',
						{ className: 'savage-card-link' },
						wp.element.createElement(
							'span',
							{ className: 'screen-reader-text' },
							'Read article "Test2"'
						)
					)
				)
			)
		);
	}
});

/***/ })
/******/ ]);
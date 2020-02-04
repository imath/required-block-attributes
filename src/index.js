const { createElement } = wp.element;
const { TextControl, SelectControl } = wp.components;
const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;

registerBlockType( 'required-block-attributes/example', {
	title: __( 'Required Block Attributes', 'required-block-attributes' ),

	description: __( 'An example block to demo Required Block Attributes.', 'required-block-attributes' ),

	supports: {
		className: true,
		anchor: true,
		multiple: false,
		reusable: false,
	},

	icon: 'warning',

	category: 'common',

	attributes: {
		attributeOne: {
			type: 'string',
		},
		attributeTwo: {
			type: 'string',
		},
	},

	edit: function( { attributes, setAttributes } ) {
		const selected = attributes.attributeTwo ? attributes.attributeTwo : '';
		const options = [
			{ label: __( 'Select a value', 'risk-ops' ), value: '' },
			{ label: __( 'Value One', 'risk-ops' ), value: 'valueone' },
			{ label: __( 'Value Two', 'risk-ops' ), value: 'valuetwo' },
		];

		return (
			<div>
				<h2>{ __( 'Test Form', 'required-block-attributes' ) }</h2>
				<hr/>
				<TextControl
					label={ __( 'Test Attribute One (required)', 'required-block-attributes' ) }
					value={ attributes.attributeOne }
					onChange={ ( text ) => {
						setAttributes( { attributeOne: text } );
					} }
				/>
				<SelectControl
					label={ __( 'Test Attribute Two (required)', 'required-block-attributes' ) }
					value={ selected }
					options={ options }
					onChange={ ( option ) => {
						setAttributes( { attributeTwo: option } );
					} }
				/>
			</div>
		);
	},

	save: function( { attributes } ) {
		return (
			<div>
				<h2>{ __( 'Tested Form', 'required-block-attributes') }</h2>
				<div className="label">
					<span>{ __( 'Tested Attribute One', 'required-block-attributes' ) }</span>
				</div>
				<div className="value">
					<span>{ attributes.attributeOne }</span>
				</div>
				<div className="label">
					<span>{ __( 'Tested Attribute Two', 'required-block-attributes' ) }</span>
				</div>
				<div className="value">
					<span>{ attributes.attributeTwo }</span>
				</div>
			</div>
		);
	},
} );

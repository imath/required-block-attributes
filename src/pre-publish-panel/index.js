/**
 * WordPress dependencies.
 */
const { registerPlugin } = wp.plugins;
const { PluginPrePublishPanel } = wp.editPost;
const { Dashicon } = wp.components;
const { compose } = wp.compose;
const { withSelect, withDispatch } = wp.data;
const { __ } = wp.i18n;

/**
 * External dependencies.
 */
const { memoize, filter, each, find } = lodash;

/**
 * Internal dependencies.
 */
import './style.css';

const RequiredBlockAttributesPrePublishPanel = ( { blockTypes, postBlocks, onSelectBlock, disableSaveButton, enableSaveButton } ) => {
	let requiredAttributes = [];

	// Pick the Block Types containing required attributes.
	const blockTypesAttributes = filter( blockTypes, 'requiredAttributes' );

	// Loop in blocks added to the document.
	if ( postBlocks ) {
		each( postBlocks, ( postBlock, keyPostBlock ) => {
			// Only keep those having their type corresponding to a Block Type containing required attributes.
			let matchingBlockType = find( blockTypesAttributes, [ 'name', postBlock.name ] );

			if ( matchingBlockType ) {
				let parent = [];
				let children = [];

				// Lists the labels of matching Required Block Attributes.
				each( matchingBlockType.requiredAttributes, ( required, keyRequired ) => {
					if ( ! postBlock.attributes[ required.name ] ) {
						children.push( <li key={ 'required-block-attribute-' + keyRequired }>{ required.label }</li> )
					}
				} );

				if ( children && 0 !== children.length ) {
					// The Block Type Icon.
					parent.push(
						<div className="required-block-attributes-block-type" key={ 'block-type-button-' + keyPostBlock }>
							<button onClick={ () => onSelectBlock( postBlock.clientId ) } className="components-button">
								<Dashicon icon={ matchingBlockType.icon.src } />
							</button>
						</div>
					);

					parent.push(
						<ul className="required-block-attributes-fields" key={ 'fields-list' + keyPostBlock }>
							{ children }
						</ul>
					);

					requiredAttributes.push(
						<div className="required-block-attributes-container" key={ 'block-type-attributes-container' + keyPostBlock }>
							{ parent }
						</div>
					);
				}
			}
		} );
	}

	if ( ! requiredAttributes || 0 === requiredAttributes.length ) {
		enableSaveButton();
		return null;
	}

	disableSaveButton();

    return (
		<PluginPrePublishPanel
			title={ __( 'Required information is missing', 'required-block-attributes' ) }
			icon="warning"
			initialOpen={ true }
			className="required-block-attributes"
		>
			<p>{ __( 'Please make sure to fill in the following fields:', 'required-block-attributes' ) }</p>
			{ requiredAttributes }
			<p className="description">
				{ __( 'Clicking on the block type icon will activate the block corresponding to the field(s) listed.', 'required-block-attributes' ) }
			</p>
        </PluginPrePublishPanel>
    );
}

const RequiredBlockAttributesPrePublishPanelInfo = compose( [
	withSelect( ( select ) => {
		const postBlocks = memoize(
			() => {
				return select( 'core/block-editor' ).getBlocks();
			}
		);

		return {
			blockTypes: select( 'core/blocks' ).getBlockTypes(),
			postBlocks: postBlocks(),
		};
	} ),
	withDispatch( ( dispatch ) => ( {
		onSelectBlock( clientId ) {
			dispatch( 'core/block-editor' ).selectBlock( clientId );
		},
		disableSaveButton() {
			dispatch( 'core/editor' ).lockPostSaving( 'required-block-attributes' );
		},
		enableSaveButton() {
			dispatch( 'core/editor' ).unlockPostSaving( 'required-block-attributes' );
		},
	} ) ),
] )( RequiredBlockAttributesPrePublishPanel );

registerPlugin( 'required-block-attributes-pre-publish-panel', { render: RequiredBlockAttributesPrePublishPanelInfo } );

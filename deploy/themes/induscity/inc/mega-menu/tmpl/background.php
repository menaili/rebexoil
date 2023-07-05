<% var itemId = data['menu-item-db-id']; %>
<div id="tamm-panel-background" class="tamm-panel-background tamm-panel">
	<p class="background-image">
		<label><?php esc_html_e( 'Background Image', 'induscity' ) ?></label><br>
		<span class="background-image-preview">
			<% if ( megaData.background.image ) { %>
				<img src="<%= megaData.background.image %>">
			<% } %>
		</span>

		<button type="button" class="button remove-button <% if ( ! megaData.background.image ) { print( 'hidden' ) } %>"><?php esc_html_e( 'Remove', 'induscity' ) ?></button>
		<button type="button" class="button upload-button" id="background_image-button"><?php esc_html_e( 'Select Image', 'induscity' ) ?></button>

		<input type="hidden" name="<%= taMegaMenu.getFieldName( 'background.image', itemId ) %>" value="<%= megaData.background.image %>">
	</p>

	<p class="background-color">
		<label><?php esc_html_e( 'Background Color', 'induscity' ) ?></label><br>
		<input type="text" class="background-color-picker" name="<%= taMegaMenu.getFieldName( 'background.color', itemId ) %>" value="<%= megaData.background.color %>">
	</p>

	<p class="background-repeat">
		<label><?php esc_html_e( 'Background Repeat', 'induscity' ) ?></label><br>
		<select name="<%= taMegaMenu.getFieldName( 'background.repeat', itemId ) %>">
			<option value="no-repeat" <% if ( 'no-repeat' == megaData.background.repeat ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'No Repeat', 'induscity' ) ?></option>
			<option value="repeat" <% if ( 'repeat' == megaData.background.repeat ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Tile', 'induscity' ) ?></option>
			<option value="repeat-x" <% if ( 'repeat-x' == megaData.background.repeat ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Tile Horizontally', 'induscity' ) ?></option>
			<option value="repeat-y" <% if ( 'repeat-y' == megaData.background.repeat ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Tile Vertically', 'induscity' ) ?></option>
		</select>
	</p>

	<p class="background-position background-position-x">
		<label><?php esc_html_e( 'Background Position', 'induscity' ) ?></label><br>

		<select name="<%= taMegaMenu.getFieldName( 'background.position.x', itemId ) %>">
			<option value="left" <% if ( 'left' == megaData.background.position.x ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Left', 'induscity' ) ?></option>
			<option value="center" <% if ( 'center' == megaData.background.position.x ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Center', 'induscity' ) ?></option>
			<option value="right" <% if ( 'right' == megaData.background.position.x ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Right', 'induscity' ) ?></option>
			<option value="custom" <% if ( 'custom' == megaData.background.position.x ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Custom', 'induscity' ) ?></option>
		</select>

		<input
			type="text"
			name="<%= taMegaMenu.getFieldName( 'background.position.custom.x', itemId ) %>"
			value="<%= megaData.background.position.custom.x %>"
			class="<% if ( 'custom' != megaData.background.position.x ) { print( 'hidden' ) } %>">
	</p>

	<p class="background-position background-position-y">
		<select name="<%= taMegaMenu.getFieldName( 'background.position.y', itemId ) %>">
			<option value="top" <% if ( 'top' == megaData.background.position.y ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Top', 'induscity' ) ?></option>
			<option value="center" <% if ( 'center' == megaData.background.position.y ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Middle', 'induscity' ) ?></option>
			<option value="bottom" <% if ( 'bottom' == megaData.background.position.y ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Bottom', 'induscity' ) ?></option>
			<option value="custom" <% if ( 'custom' == megaData.background.position.y ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Custom', 'induscity' ) ?></option>
		</select>
		<input
			type="text"
			name="<%= taMegaMenu.getFieldName( 'background.position.custom.y', itemId ) %>"
			value="<%= megaData.background.position.custom.y %>"
			class="<% if ( 'custom' != megaData.background.position.y ) { print( 'hidden' ) } %>">
	</p>

	<p class="background-attachment">
		<label><?php esc_html_e( 'Background Attachment', 'induscity' ) ?></label><br>
		<select name="<%= taMegaMenu.getFieldName( 'background.attachment', itemId ) %>">
			<option value="scroll" <% if ( 'scroll' == megaData.background.attachment ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Scroll', 'induscity' ) ?></option>
			<option value="fixed" <% if ( 'fixed' == megaData.background.attachment ) { print( 'selected="selected"' ) } %>><?php esc_html_e( 'Fixed', 'induscity' ) ?></option>
		</select>
	</p>
</div>
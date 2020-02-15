/**
 * This script adds checkbox for gutenberg editor
 */
jQuery(document).ready(function () {

	const { FormToggle } = wp.components
	const { PluginPostStatusInfo } = wp.editPost
	const { compose, withInstanceId } = wp.compose
	const { withSelect, withDispatch } = wp.data
	const { registerPlugin } = wp.plugins

	const Render = ({ isChecked = false, isPostPasswordProtected, updateCheck, instanceId }) => {
	  const callback = () => updateCheck(!isChecked)

	  if( isPostPasswordProtected ) {

		  const id = instanceId + '-editors-pick'
		  return (
		    <PluginPostStatusInfo>
		      <label htmlFor={id}><strong>Password Protect</strong> all children</label>
		      <FormToggle
		        key='toggle'
		        checked={ isChecked }
		        onChange={ callback }
		        id={id}
		      />
		    </PluginPostStatusInfo>
		  )
	  }
	  else {
	  	
	  	updateCheck(false);

	  	return (
		  	<PluginPostStatusInfo></PluginPostStatusInfo>
	  	)
	  }

	}

	const PTC_StatusFill = compose(
	  [
	    withSelect((select) => {
	      return {
	        isChecked: select('core/editor').getEditedPostAttribute('meta').protect_children,
	        isPostPasswordProtected: select('core/editor').getEditedPostVisibility() == 'password'
	      }
	    }),
	    withDispatch((dispatch) => {
	      return {
	        updateCheck (protect_children) {
	          dispatch('core/editor').editPost({ meta: { protect_children } })
	        }
	      }
	    }
	    ),
	    withInstanceId
	  ]
	)(Render)

	registerPlugin('recipe-editors-pick', {
	  render: PTC_StatusFill
	})


});
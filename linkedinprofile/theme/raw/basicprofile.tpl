{if $profile}
{assign var="formattedname" value="formatted-name"}
{assign var="pictureurl" value="picture-url"}
{assign var="publicurl" value="public-profile-url"}

<div id="linkedin_basic_profile">
	<table width="100%">
	  <tr valign="top">
	    <td>
          <div id="name">{$profile.$formattedname}</div>
          <div id="headline">{$profile.headline}</div>
          <div id="location">{$profile.location.name}</div>
		</td>
		<td>
          <img src="{$profile.$pictureurl}" id="linkedin_profile_picture">
		  <br /><a href="{$profile.$publicurl}" target="_blank" class="btn btn-primary">{str tag=viewprofile section=blocktype.linkedinprofile}</a>
		</td>
	  </tr>
	</table>
</div>
{/if}
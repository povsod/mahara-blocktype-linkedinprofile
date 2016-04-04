{if $profile}
{assign var="formattedname" value="formatted-name"}
{assign var="pictureurls" value="picture-urls"}
{assign var="pictureurl" value="picture-url"}
{assign var="publicurl" value="public-profile-url"}
{assign var="attr" value="@attributes"}

{assign var="emailaddress" value="email-address"}
{assign var="twitter" value="primary-twitter-account"}
{assign var="account" value="provider-account-name"}
{assign var="phones" value="phone-numbers"}
{assign var="phone" value="phone-number"}
{assign var="address" value="main-address"}
{assign var="urls" value="member-url-resources"}
{assign var="url" value="member-url"}

<div id="linkedin_contact_info">
    <div id="header">
	<table width="100%">
	  <tr valign="top">
	    <td width="130">
          <img src="{$profile.$pictureurls.$pictureurl}" id="linkedin_big_profile_picture">
		</td>
		<td colspan="2">
          <div id="name">{$profile.$formattedname}</div>
          <div id="headline">{$profile.headline}</div>
          <div id="location">{$profile.location.name}</div>
		</td>
	  </tr>
	  <tr valign="top">
	    <td rowspan="2">
		  <a class="btn btn-primary" href="{$profile.$publicurl}">{str tag=viewprofile section=blocktype.linkedinprofile}</a>
		</td>
	    <td width="80">
		  {if $profile.$emailaddress}{str tag=Email section=blocktype.linkedinprofile}{/if}
		</td>
		<td>
		  {if $profile.$emailaddress}<a href="mailto:{$profile.$emailaddress}">{$profile.$emailaddress}</a>{/if}
		</td>
	  </tr>
	  <tr valign="top">
	    <td width="80">
		  {if $profile.$publicurl}{str tag=Linkedin section=blocktype.linkedinprofile}{/if}
		</td>
		<td>
		  {if $profile.$publicurl}<a href="{$profile.$publicurl}">{$profile.$publicurl}</a>{/if}
		</td>
	  </tr>
	  {if $profile.$urls}
	  <tr valign="top">
	    <td></td>
	    <td width="80">
		  {str tag=Websites section=blocktype.linkedinprofile}
		</td>
		<td>
		  {if $profile.$urls.$attr.total == 1}
            {assign var=url value=$profile.$urls.$url}
            <a href="{$url.url}">{$url.name}</a>
          {else}
            {foreach from=$profile.$urls.$url item=url}
              <a href="{$url.url}">{$url.name}</a><br>
            {/foreach}
          {/if}
		</td>
	  </tr>
	  {/if}
	  {if $profile.$phones.$phone.$phone}
	  <tr valign="top">
	    <td></td>
	    <td width="80">
		  {str tag=Phone section=blocktype.linkedinprofile}
		</td>
		<td>
          {$profile.$phones.$phone.$phone}
		</td>
	  </tr>
	  {/if}
	  {if $profile.$address}
	  <tr valign="top">
	    <td></td>
	    <td width="80">
		  {str tag=Address section=blocktype.linkedinprofile}
		</td>
		<td>
          {nl2br($profile.$address)}
		</td>
	  </tr>
	  {/if}
	</table>
    </div>
</div>
{/if}
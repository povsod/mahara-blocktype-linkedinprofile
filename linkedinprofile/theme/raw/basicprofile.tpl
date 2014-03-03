{if $profile}
{assign var="formattedname" value="formatted-name"}
{assign var="pictureurl" value="picture-url"}
{assign var="publicurl" value="public-profile-url"}

<link rel="stylesheet" type="text/css" href="{$WWWROOT}blocktype/linkedinprofile/theme/raw/static/style/style.css">
<div id="linkedin_basic_profile">
    <img src="{$profile.$pictureurl}" id="linkedin_profile_picture">
    <h2><a href="{$profile.$publicurl}" target="_blank">{$profile.$formattedname}</a></h2>
    <div id="headline">{$profile.headline}</div>
    <div id="location">{$profile.location.name}</div>
    <p><a href="{$profile.$publicurl}" target="_blank" class="btn">{str tag=viewprofile section=blocktype.linkedinprofile}</a></p>
</div>
{/if}
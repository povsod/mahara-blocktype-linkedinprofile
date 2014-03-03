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

<link rel="stylesheet" type="text/css" href="{$WWWROOT}blocktype/linkedinprofile/theme/raw/static/style/style.css">
<div id="linkedin_contact_info">
    <div id="header">
        <img src="{$profile.$pictureurls.$pictureurl}" id="linkedin_big_profile_picture">
        <div id="name">{$profile.$formattedname}</div>
        <div id="headline">{$profile.headline}</div>
        <div id="location">{$profile.location.name}</div>
    </div>
    <div id="overview" class="cb">
    <dl>
        {if $profile.$emailaddress}
        <dt>{str tag=Email section=blocktype.linkedinprofile}</dt>
        <dd><a href="mailto:{$profile.$emailaddress}">{$profile.$emailaddress}</a></dd>
        {/if}
        {if $profile.$publicurl}
        <dt>{str tag=Linkedin section=blocktype.linkedinprofile}</dt>
        <dd><a href="{$profile.$publicurl}">{$profile.$publicurl}</a></dd>
        {/if}
        {if $profile.$twitter.$account}
        <dt>{str tag=Twitter section=blocktype.linkedinprofile}</dt>
        <dd><a href="https://twitter.com/{$profile.$twitter.$account}">@{$profile.$twitter.$account}</a></dd>
        {/if}
        {if $profile.$urls}
        <dt>{str tag=Websites section=blocktype.linkedinprofile}</dt>
        <dd>{if $profile.$urls.$attr.total == 1}
                {assign var=url value=$profile.$urls.$url}
                <a href="{$url.url}">{$url.name}</a>
            {else}
                {foreach from=$profile.$urls.$url item=url}
                    <a href="{$url.url}">{$url.name}</a><br>
                {/foreach}
            {/if}
        </dd>
        {/if}
        {if $profile.$phones.$phone.$phone}
        <dt>{str tag=Phone section=blocktype.linkedinprofile}</dt>
        <dd>{$profile.$phones.$phone.$phone}</dd>
        {/if}
        {if $profile.$address}
        <dt>{str tag=Address section=blocktype.linkedinprofile}</dt>
        <dd>{nl2br($profile.$address)}</dd>
        {/if}
    </dl>
    </div>
</div>
{/if}
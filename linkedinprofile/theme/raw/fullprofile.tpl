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

{assign var="current" value="three-current-positions"}
{assign var="past" value="three-past-positions"}
{assign var="schoolname" value="school-name"}
{assign var="connections" value="num-connections"}
{assign var="start" value="start-date"}
{assign var="end" value="end-date"}
{assign var="iscurrent" value="is-current"}
{assign var="fieldofstudy" value="field-of-study"}
{assign var="groups" value="group-memberships"}
{assign var="group" value="group-membership"}


<link rel="stylesheet" type="text/css" href="{$WWWROOT}blocktype/linkedinprofile/theme/raw/static/style/style.css">
<div id="linkedin_full_profile">
    <div id="header">
        <img src="{$profile.$pictureurls.$pictureurl}" id="linkedin_big_profile_picture">
        <div id="name">{$profile.$formattedname}</div>
        <div id="headline">{$profile.headline}</div>
        <div id="location">{$profile.location.name}</div>
    </div>
    <div id="overview" class="cb">
    <dl>
        {if $profile.$current}
        <dt>{str tag=Current section=blocktype.linkedinprofile}</dt>
        <dd>{if $profile.$current.$attr.total == 1}
                {assign var=pos value=$profile.$current.position}
                <strong>{$pos.title} {str tag=at} {$pos.company.name}</strong>
            {else}
                {foreach from=$profile.$current.position item=pos}
                    <strong>{$pos.title} {str tag=at} {$pos.company.name}</strong><br>
                {/foreach}
            {/if}
        </dd>
        {/if}
        {if $profile.$past}
        <dt>{str tag=Past section=blocktype.linkedinprofile}</dt>
        <dd>{if $profile.$past.$attr.total == 1}
                {assign var=pos value=$profile.$past.position}
                {$pos.title} {str tag=at} {$pos.company.name}
            {else}
                {foreach from=$profile.$past.position item=pos}
                    {$pos.title} {str tag=at} {$pos.company.name}<br>
                {/foreach}
            {/if}
        </dd>
        {/if}
        {if $profile.educations}
        <dt>{str tag=Education section=blocktype.linkedinprofile}</dt>
        <dd>{if $profile.educations.$attr.total == 1}
                {assign var=edu value=$profile.educations.education}
                {$edu.$schoolname}
            {else}
                {foreach from=$profile.educations.education item=edu}
                    {$edu.$schoolname}<br>
                {/foreach}
            {/if}
        </dd>
        {/if}
        {if $profile.$connections}
        <dt>{str tag=Connections section=blocktype.linkedinprofile}</dt>
        <dd><strong>{$profile.$connections}</strong> {str tag=connections section=blocktype.linkedinprofile}</dd>
        {/if}
    </dl>
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
{if $profile.summary || $profile.specialties}
<div id="linkedin_full_profile_summary">
    <h2>{str tag=Summaryof section=blocktype.linkedinprofile args=$profile.$formattedname}</h2>
    <div id="content">
    {if $profile.summary}<p>{$profile.summary}</p>{/if}
    {if $profile.specialties}<p>{str tag=Specialties section=blocktype.linkedinprofile}:<br>{$profile.specialties}</p>{/if}
    </div>
</div>
{/if}
{if $profile.positions}
<div id="linkedin_full_profile_experience">
    <h2>{str tag=Experienceof section=blocktype.linkedinprofile args=$profile.$formattedname}</h2>
    <div id="content">
    {if $profile.positions.$attr.total == 1}
        {assign var=pos value=$profile.positions.position}
        <h4>{$pos.title}</h4>
        <strong>{$pos.company.name}</strong><br>
        <span class="description">{str tag='month.$pos.$start.month' section=blocktype.linkedinprofile}&nbsp;{$pos.$start.year}&nbsp;–&nbsp;{if $pos.$iscurrent == 'true'}{str tag=present section=blocktype.linkedinprofile}{else}{str tag='month.$pos.$end.month' section=blocktype.linkedinprofile}&nbsp;{$pos.$end.year}{/if}</span><br>
        <div>{$pos.summary}</div>
    {else}
        {foreach from=$profile.positions.position item=pos}
            <h4>{$pos.title}</h4>
            <strong>{$pos.company.name}</strong><br>
            <span class="description">{str tag='month.$pos.$start.month' section=blocktype.linkedinprofile}&nbsp;{$pos.$start.year}&nbsp;–&nbsp;{if $pos.$iscurrent == 'true'}{str tag=present section=blocktype.linkedinprofile}{else}{str tag='month.$pos.$end.month' section=blocktype.linkedinprofile}&nbsp;{$pos.$end.year}{/if}</span><br>
            <div>{$pos.summary}</div>
        {/foreach}
    {/if}
    </div>
</div>
{/if}
{if $profile.languages}
<div id="linkedin_full_profile_languages">
    <h2>{str tag=Languagesof section=blocktype.linkedinprofile args=$profile.$formattedname}</h2>
    <div id="content"><ul>
    {if $profile.languages.$attr.total == 1}
        {assign var=lang value=$profile.languages.language}
        <li>{$lang.language.name}</li>
    {else}
        {foreach from=$profile.languages.language item=lang}
            <li>{$lang.language.name}</li>
        {/foreach}
    {/if}
    </ul></div>
</div>
{/if}
{if $profile.skills}
<div id="linkedin_full_profile_skills">
    <h2>{str tag=Skillsof section=blocktype.linkedinprofile args=$profile.$formattedname}</h2>
    <div id="content"><p>
    {if $profile.skills.$attr.total == 1}
        {assign var=skill value=$profile.skills.skill}
        <span>{$skill.skill.name}</span>
    {else}
        {foreach from=$profile.skills.skill item=skill}
            <span>{$skill.skill.name}</span>
        {/foreach}
    {/if}
    </p></div>
</div>
{/if}
{if $profile.educations}
<div id="linkedin_full_profile_education">
    <h2>{str tag=Educationof section=blocktype.linkedinprofile args=$profile.$formattedname}</h2>
    <div id="content">
    {if $profile.educations.$attr.total == 1}
        {assign var=pos value=$profile.positions.position}
        <h4>{$pos.title}</h4>
        <strong>{$pos.company.name}</strong><br>
        <span class="description">{str tag='month.$pos.$start.month' section=blocktype.linkedinprofile}&nbsp;{$pos.$start.year}&nbsp;–&nbsp;{if $pos.$iscurrent == 'true'}{str tag=present section=blocktype.linkedinprofile}{else}{str tag='month.$pos.$end.month' section=blocktype.linkedinprofile}&nbsp;{$pos.$end.year}{/if}</span><br>
        <div>{$pos.summary}</div>
    {else}
        {foreach from=$profile.educations.education item=edu}
            <h4>{$edu.$schoolname}</h4>
            <div>{$edu.degree}{if is_string($edu.$fieldofstudy)}, {$edu.$fieldofstudy}{/if}</div>
            <span class="description">{$edu.$start.year}&nbsp;–&nbsp;{$edu.$end.year}</span><br>
        {/foreach}
    {/if}
    </div>
</div>
{/if}
{if $profile.$groups}
<div id="linkedin_full_profile_groups">
    <h2>{str tag=Groupsof section=blocktype.linkedinprofile args=$profile.$formattedname}</h2>
    <div id="content"><ul>
    {if $profile.$groups.$attr.total == 1}
        {assign var=grp value=$profile.$groups.$group}
        <li><a href="http://www.linkedin.com/groups?gid={$grp.group.id}" target="_blank">{$grp.group.name}</a></li>
    {else}
        {foreach from=$profile.$groups.$group item=grp}
            <li><a href="http://www.linkedin.com/groups?gid={$grp.group.id}" target="_blank">{$grp.group.name}</a></li>
        {/foreach}
    {/if}
    </ul></div>
</div>
{/if}

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

<div id="linkedin_full_profile">
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
	    <td width="130" rowspan="2">&nbsp;</td>
	    <td width="80">
		  {if $profile.$connections}{str tag=Connections section=blocktype.linkedinprofile}{/if}
		</td>
		<td>
		  {if $profile.$connections}<strong>{$profile.$connections}</strong> {str tag=connections section=blocktype.linkedinprofile}{/if}
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
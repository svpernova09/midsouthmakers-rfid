<p>
    Hello {{ $user->email }},
</p>
<p>
Someone has requested to link {{ $user->discord_username }} to your rfid.midsouthmakers.org account. Please click the link below to continue.
</p>
<p>
    {{ $user->discord_hash }}
</p>
<p>
If you did *not* request this please inform a board member.
</p>

- MidsouthMakers<br />
www.MidsouthMakers.org
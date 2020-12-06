<p>
    Hello {{ $user->email }},
</p>
<p>
Someone has requested to link {{ $user->discord_username }} to your rfid.midsouthmakers.org account. Please click the link below to continue.
</p>
<p>
    <a href="{{ route('auth.discord.verify', $user->discord_hash) }}" target="_blank">
        {{ route('auth.discord.verify', $user->discord_hash) }}
    </a>
</p>
<p>
    {{ route('auth.discord.verify', $user->discord_hash) }}
</p>
<p>
If you did *not* request this please inform a board member.
</p>

- MidsouthMakers<br />
www.MidsouthMakers.org
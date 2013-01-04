$TTL	10800
@	IN	SOA	example.com. admin.example.com. (
			2013010200	; Serial
			10800		; Refresh
			3600		; Retry
			604800		; Expire
			10800		; Negative Cache TTL
)

@		NS	ns1.example.com.
@		NS	ns1.example.com.

test		A	8.8.8.8
test.example.com.		TXT	Privet!
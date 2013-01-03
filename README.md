Bind Frontend
=============

Bind Zone File Format
---------------------

    host = fqdn|relative_name|@|space|mask
    type = IN|CN|HS
    ttl = ttl{int32}
    class = A|AAAA|A6|AFSDB|APL|CERT|CNAME|DNAME|GPOS|HINFO|ISDN|KEY|KX|LOC|MX|NAPTR|NSAP|NS|NXT|PTR|PX|RP|RT|SIG|SOA|SRV|TXT|WKS|X25
    rdata = [cdata]
    rdata (A) = ipv4
    rdata (AAAA) = ipv6
    rdata (MX) = priority{int16} domain
    rdata (CNAME) = domain
    rdata (SRV) = priority weight port target
    rdata (TXT) = cdata
    rdata (NS) = fqdn|relative_name
    resource_record = host [type] [ttl] class rdata
    line = resource_record|directive

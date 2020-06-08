# Usage Strategy

In the beginning this module is installed with disabled functionality. All CSP header directives are added by Magento itself. CSP violations are reported in browser console and are not sent back to the server.



## Collection Phase

Enable general functionality in [config](./config.md) (`General`) then enable reports collection for developers (`Reports / Developers Only`) and set IP address of your workstations (or comma-separated list of IP addresses) - `Reports / Developers IPs`.

Surf your store from your workstation and collect CSV reports caused by your activity only. The violations are repeated for all visitors and you need just one visitor to collect the most of them. Control reports using [reports](./grid/reports.md) grid in admin.

Run [command](./command.md) to analyze reports and to generate CSP rules to prevent reported violations:
```shell script
$ ./bin/magento fl32:csp:analyze 
``` 
Control generated rules using [rules](./grid/rules.md) grid in admin.

At the collection phase all visitors will get CSP directives in `Content-Security-Policy-Report-Only` but only developers workstations will have `report-uri` directive to report violations. Violations for other visitors will be reported into browser console. So your server will not be overloaded with the same reports from other visitors (each violation generates one report, one page can have a lot of violations).



## Production Phase

Disable `Reports / Developers Only` configuration option. Your collected CSP rules will be applied to all visitors, any violation will be reported to the server. Cron job will analyze all collected reports and will generate new rules every hour. All analyzed reports will be deleted.



## Paranoid Mode

Disable `Cron` in configuration after the most of possible reports will be collected and analyzed then switch `Rules / Report Only` to `No`. `Content-Security-Policy` header will be used instead of `Content-Security-Policy-Report-Only`. No restricted content will be allowed more. All new violations will be reported but not be converted to rules and not be deleted. You can validate the reports and convert it to the rules [manually](./command.md).

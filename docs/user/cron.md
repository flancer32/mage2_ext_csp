# Cron Tasks

Analyze CSP violation reports and compose policy rules:
```xml
    <group id="default">
        <job name="fl32_csp_analyze" instance="Flancer32\Csp\Cron\Analyze" method="execute">
            <schedule>40 * * * *</schedule>
        </job>
    </group>
```

Task starts hourly.

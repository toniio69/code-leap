Set-Location c:\Users\aodon\Desktop\code-leap
$p = Start-Process -FilePath 'php' -ArgumentList 'vendor\phpunit\phpunit\phpunit','tests/Feature/Settings/SettingsRouteAccessTest.php','--no-progress' -WorkingDirectory (Get-Location) -NoNewWindow -PassThru -RedirectStandardOutput 'pu2-out.txt' -RedirectStandardError 'pu2-err.txt'
for ($i = 0; $i -lt 9; $i++) {
    Start-Sleep -Seconds 13
    if ($p.HasExited) { break }
}
Write-Output "exited: $($p.HasExited) code: $($p.ExitCode)"

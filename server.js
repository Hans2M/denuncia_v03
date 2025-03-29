const { exec } = require('child_process');
const port = process.env.PORT || 10000;

// Inicia el servidor PHP
const phpProcess = exec(`php -S 0.0.0.0:${port} -t public`, (error, stdout, stderr) => {
    if (error) {
        console.error(`Error: ${error}`);
        return;
    }
    console.log(`stdout: ${stdout}`);
    console.error(`stderr: ${stderr}`);
});

phpProcess.stdout.pipe(process.stdout);
phpProcess.stderr.pipe(process.stderr);

// Manejo de cierre limpio
process.on('SIGTERM', () => {
    phpProcess.kill();
    process.exit(0);
});
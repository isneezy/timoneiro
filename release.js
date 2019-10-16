#!/usr/bin/env node
const pkg = require('./package')
const { spawn, execSync } = require('child_process')

function buildAssets () {
  const prod = spawn('yarn', ['prod'])
  prod.stdout.pipe(process.stdout)
  prod.stderr.pipe(process.stderr)
  prod.stdin.pipe(process.stdin)
  return new Promise((resolve, reject) => {
    prod.on('exit', function (code) {
      if (code !== 0) {
        reject(code)
      } else {
        execSync('git add -f mix-manifest.json')
        execSync('git add -f publishable/assets')
        resolve(code)
      }
    })
  })
}

function release (program) {
  const arguments = ['version']
  if (program.type) {
    arguments.push(`--${program.type}`)
  }
  if (program.alpha) {
    arguments.push('--prerelease')
    arguments.push('--preid')
    arguments.push('alpha')
  }
  if (program.beta) {
    arguments.push('--prerelease')
    arguments.push('--preid')
    arguments.push('beta')
  }

  const prod = spawn('yarn', arguments)
  prod.stdout.pipe(process.stdout)
  prod.stderr.pipe(process.stderr)
  prod.stdin.pipe(process.stdin)

  return new Promise((resolve, reject) => {
    prod.on('exit', (code) => {
      if (code !== 0) {
        return reject(code)
      } else {

        return resolve(code)
      }
    })
  })
}

const program = require('commander')
program.version(pkg.version)

program.option('-t, --type <type>', 'type of the release [major, minor, patch]')
program.option('-a, --alpha', 'flag it as a alpha release')
program.option('-b --beta', 'flag it as a beta release')

program.parse(process.argv)
buildAssets().then(() => release(program))
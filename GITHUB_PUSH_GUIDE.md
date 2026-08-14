# GitHub Push Guide - Bren Payroll Information System

This guide shows how to upload this Laravel project to GitHub.

## 1) Create the GitHub repository

1. Open GitHub.
2. Click New repository.
3. Use this name:
   - `bren-payroll-information-system`
4. Choose Public or Private.
5. Do not initialize with README, .gitignore, or license.
6. Click Create repository.

## 2) Create a Personal Access Token (PAT)

1. Go to GitHub → Settings → Developer settings → Personal access tokens.
2. Click Generate new token.
3. Give it a name such as `git-cli-push`.
4. Select the repo scope.
5. Copy the token and keep it in a safe place.

Important:
- Do not paste the PAT into the repository files.
- Use it only when Git prompts for a password.

## 3) Open PowerShell and run these commands

```powershell
Set-Location 'C:\xampp\htdocs\Bren-Payroll-information-system'

$env:Path += ';C:\Program Files\Git\cmd'

git remote set-url origin https://github.com/PVTec/bren-payroll-information-system.git
git push -u origin main
```

If Git says `git` is not recognized, use this first:

```powershell
$env:Path += ';C:\Program Files\Git\cmd'
git --version
```

## 4) When Git asks for credentials

Use:
- Username: `PVTec`
- Password: your GitHub PAT

Do not use your normal GitHub password.

## 5) First-time commit workflow

From the project folder:

```powershell
git init
git add .
git commit -m "First drop ng buong Laravel project"
git branch -M main
git remote add origin https://github.com/PVTec/bren-payroll-information-system.git
git push -u origin main
```

## 6) Normal workflow for future updates

```powershell
git add .
git commit -m "Your commit message"
git push origin main
```

## 7) If push is rejected

Common causes:
- repository not created yet
- wrong GitHub account
- expired PAT
- PAT missing repo permission

Fix:
- check the repo URL
- create a new PAT
- use the same GitHub account
- retry `git push`

## 8) Quick check

```powershell
git status
git remote -v
git branch
```

This is the safe, working GitHub push flow for this Laravel project.

<p align="center"><img src="https://cdn.svarun.dev/gh/actions.png" width="150px"/></p>

# VS Utility - ***Github Action***

```diff
- Public Use Of This Action Is Not ADVISED. ⚠️  Use @ Your OWN RISK
```

## ENV Variables 

### Default Environment Variables exposed by GitHub
For a full list of default environment variables exposed by GitHub see https://help.github.com/en/actions/configuring-and-managing-workflows/using-environment-variables#default-environment-variables.
| Name | Desc | Example |
|---|---|---|
|`GITHUB_ACTOR`| The name of the person or app that initiated the workflow. | `octocat` |
|`GITHUB_REPOSITORY`| The owner and repository name. | `octocat/action` |
|`GITHUB_SHA`| The commit SHA that triggered the workflow. | `ffac537e6cbbf934b08745a378932722df287a53` |
|`GITHUB_REF`| The branch or tag ref that triggered the workflow. If neither a branch or tag is available for the event type, the variable will not exist. | `refs/heads/feature-branch-1` |

### Github Related Variables
| Name | Desc | Example |
|---|---|---|
|`GITHUB_REPOSITORY_OWNER`| The owner of the repository  | `varunsridharan/your-git-repo` => `varunsridharan` |
|`GITHUB_REPOSITORY_NAME`| The name of the repository  | `varunsridharan/your-git-repo` => `your-git-repo` |
|`GITHUB_REF_NAME`| The branch name that triggered the workflow. If neither a branch or tag is available for the event type, the variable will not exist. | `feature-branch-1` |
|`GITHUB_SHA_SHORT`| The shortened commit SHA (8 characters) that triggered the workflow. | `ffac537e` |


### Workflow Hook Related Variables
| Name | Desc | Default |
|---|---|---|
| `VS_BEFORE_HOOK_FILE` | Custom Hook File Name | `before.sh` |
| `VS_AFTER_HOOK_FILE` | Custom Hook File Name | `before.sh` 
| `VS_BEFORE_HOOK_FILE_LOCATION` | Exact Location Of The Hook File | `./.github/workflows/before.sh` 
| `VS_AFTER_HOOK_FILE_LOCATION` | Exact Location Of The Hook File | `./.github/workflows/after.sh` 

### Gitbook Change Log Updater Related Variables
| Name | Desc | Default |
|---|---|---|
| `CHLOG_REPO_ORG_NAME` | Gitbook's Docs Account Holder Username | `vs-docs` |
| `LOCAL_CHANGE_LOG_FILE` | Change Log File Name IN Current Repo | `CHANGELOG.md` |
| `REMOTE_CHANGE_LOG_FILE` | Change Log File Name IN Docs Repo | `change-log.md` |

### Envato Release Related Variables
| Name | Desc | Default |
|---|---|---|
| `ENVATO_DIST_IGNORE` | varunsridharan/action-envato-publish Dist Ignore File Location | `./.github/distignore.txt` |
| `ENVATO_ASSETS_DIST_IGNORE` | varunsridharan/action-envato-publish Dist Assets Ignore File Location | `./.github/assets-distignore.txt` |


---

## 🤝 Contributing
If you would like to help, please take a look at the list of [issues](issues/).

## 💰 Sponsor
[I][twitter] fell in love with open-source in 2013 and there has been no looking back since! You can read more about me [here][website].
If you, or your company, use any of my projects or like what I’m doing, kindly consider backing me. I'm in this for the long run.

- ☕ How about we get to know each other over coffee? Buy me a cup for just [**$9.99**][buymeacoffee]
- ☕️☕️ How about buying me just 2 cups of coffee each month? You can do that for as little as [**$9.99**][buymeacoffee]
- 🔰         We love bettering open-source projects. Support 1-hour of open-source maintenance for [**$24.99 one-time?**][paypal]
- 🚀         Love open-source tools? Me too! How about supporting one hour of open-source development for just [**$49.99 one-time ?**][paypal]

## 📝 License & Conduct
- [**General Public License v3.0 license**](LICENSE) © [Varun Sridharan](website)
- [Code of Conduct](code-of-conduct.md)

## 📣 Feedback
- ⭐ This repository if this project helped you! :wink:
- Create An [🔧 Issue](issues/) if you need help / found a bug

## Connect & Say 👋
- **Follow** me on [👨‍💻 Github][github] and stay updated on free and open-source software
- **Follow** me on [🐦 Twitter][twitter] to get updates on my latest open source projects
- **Message** me on [📠 Telegram][telegram]
- **Follow** my pet on [Instagram][sofythelabrador] for some _dog-tastic_ updates!

<!-- Personl Links -->
[paypal]: https://go.svarun.dev/paypal
[buymeacoffee]: https://go.svarun.dev/buymeacoffee
[sofythelabrador]: https://www.instagram.com/sofythelabrador/
[github]: https://go.svarun.dev/github/
[twitter]: https://go.svarun.dev/twitter/
[telegram]: https://go.svarun.dev/telegram/
[email]: https://go.svarun.dev/contact/email/
[website]: https://go.svarun.dev/website/

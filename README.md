# twitch-plugin
This plugin provides functionality to include easily streamdata from twitch.tv into your wordpress-application 

## Usage
### Manage Streamers
- A new posttype called "Livestream" was created
- Create for each streamer a new post
- Under *Twitchname* paste in the Accountname completely in lowercase
- ???
- Profit!

Ressources like the Avatar will be dynamicly loaded from Twitch-API

### Include Overview
- Just paste the following shortcode at desired post: `[twitch_overview]`
- You can add the parameter `visible=online` to just display the online streamers.

**Examples:**
```
[twitch_overview] // will display a full overview of all streamers and their status
[twitch_overview visible=full] // will display a full overview of all streamers and their status
[twitch_overview visible=online] // will display only the online streamers
```
`visible=full` is the default-setting

## Licence
The Twitch-Plugin is released under Creative Commons **CC BY-NC-SA**.
Feel free to use and modify my code.

## Roadmap
### Version 1.0
- [x] Integrate Twitch-Overview 
- [ ] Integrate Twitch-Stream via hidden Div
- [ ] Localize the Project

### Version 2.0
- [ ] Configure Let's Play Post-Type
- [ ] Configure Let's Play Taxonomy
- [ ] Integrate Let's Play Shortcuts

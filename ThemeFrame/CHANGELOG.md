# Release Notes

All notable changes to this project will be documented in this file.


## 2.5.3 (2023-03-05)

- Fixed an issue with type parameters when enabling single sign-on support only.


## 2.5.2 (2023-03-05)

- Added private mode user handling.
- Added display of authenticated user description on user profile page.


## 2.5.1 (2023-03-02)

- View Optimization
- Bug fixes


## 2.5.0 (2023-02-26)

- View Optimization
- Bug fixes
- Compatible with new version parameters


## 2.4.0 (2023-02-16)

- Enable or disable support for mentions and topics
- Optimise handling of user deactivation status
- Optimising the display style of user banner images
- Changed 404 page image
- Changed video cover image parameters
- Modify theme settings and add dynamic effect toggle


## 2.3.0 (2023-02-09)

- Use wrapper parameters to display version numbers
- Add page load status animation
- Lazy loading of file resources


## 2.2.0 (2023-02-01)

- Fix read notifications not being clickable
- change the anonymous parameter to isAnonymous
- Use the `fs_stickers()` function to handle the list of emoticons
- Add emoji options to the quick post and comment fields
- Optimise logic for listening to connected logins
- Optimise code parsing for hint
- Show settings link if you don't have permission to post


## 2.1.1 (2023-01-20)

- Remove useless language tag parameters of the plugin framework
- Optimize editor options style


## 2.1.0 (2023-01-18)

- Added 404 page
- Compatible with markdown parsing when policy terms are empty
- Compatibility data error when expression is empty
- Fixed content text-break
- Add alt attribute to image files
- Notification messages are set to read when clicked


## 2.0.1 (2023-01-11)

- Fix the style of image centering and text line feed


## 2.0.0 (2023-01-09)

- Official Version


## 2.0.0-beta.8 (2022-12-24)

- Posts `isAllow` parameter adjustment
- Remove Fresns text from search box and private mode pages
- Post parameter `topComment` changed to `previewComments` and changed to list
- Page can only play one video at a time


## 2.0.0-beta.7 (2022-12-13)

- The group details page shows the list of group administrators


## 2.0.0-beta.6 (2022-12-12)

- Add `redirectURL` parameter to the registration and login links
- Fix user auth modal box id
- Fix cookies configuration name
- Changed the name of configuration item from fs_api_config to fs_db_config


## 2.0.0-beta.5 (2022-12-08)

- Private mode view file move directory `portal/private.blade.php`
- Add policy terms page `portal/policies.blade.php`
- Fix the problem of group selection list loading failure when publishing


## 2.0.0-beta.4 (2022-12-01)

- Fix statistics code parameter error
- `commentPreviews` parameter name changed to `subComments`
- `interactive` parameter name changed to `interaction`
- Change the top content function to `fs_sticky_posts` and `fs_sticky_comments`.
- Fix comment like button state


## 2.0.0-beta.3 (2022-11-28)

- Group detail page shows prompt text when no right to view
- Hide display if wallet is not enabled in user menu
- Configure the key name `account_cookie_status` to `account_cookies_status`
- Configure key name `account_cookie` to `account_cookies`
- Language pack identifier name `accountPoliciesCookie` changed to `accountPoliciesCookies`
- Fix input-tips topic # number completion


## 2.0.0-beta.2 (2022-11-23)

- Add fresnsJoin listener
- Global selectable user switching


## 2.0.0-beta.1 (2022-11-22)

- Adaptation to Fresns 2.x

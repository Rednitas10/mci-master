# Frontend View Migration Tasks

This document outlines tasks for migrating the legacy CakePHP view templates in `app/views/` to the new React-based frontend under `frontend/`.

Each migration is designed to be independent so developers can work in parallel. The initial React pages should replicate the layout from `app/views/layouts/default.ctp` with minimal styling.

## 1. Base Layout
- [x] Create a React component `BaseLayout` that mirrors the structure of `app/views/layouts/default.ctp`.
- [x] Implement a `MenuBar` component based on `app/views/elements/menuBar.ctp`.
- [x] Set up React Router and wrap pages with `BaseLayout`.

## 2. Event Views
Migrate each Event view into its own React page. These can be developed concurrently.
- [x] `EventIndex` for `/events/index`
- [ ] `EventAdd` for `/events/add`
- [ ] `EventAddMany` for `/events/addMany`
- [ ] `EventAssignMany` for `/events/assignMany`
- [ ] `EventUpload` for `/events/upload`
- [ ] `EventReview` for `/events/review`
- [ ] `EventScreen` for `/events/screen`
- [ ] `EventScrub` for `/events/scrub`
- [ ] `EventViewAll` for `/events/viewAll`

## 3. User Views
- [ ] `UsersViewAll` for `/users/viewAll`
- [ ] `UserAdd` for `/users/add`
- [ ] `UserEdit` for `/users/edit`
- [ ] `UserDelete` for `/users/delete`
- [ ] `UserLogout` for `/users/logout`

## 4. Solicitation and Criteria Views
- [ ] `SolicitationAdd` and `SolicitationDelete`
- [ ] `CriteriaAdd` and `CriteriaDelete`

## 5. Error Pages
- [ ] `ErrorNotAuthorized` for `errors/not_authorized.ctp`
- [ ] `ErrorUnknownUser` for `errors/unknown_user.ctp`

- [x] `Home` page for `pages/home.ctp`

Each task should render data through API calls to the PHP backend. Styling can remain minimal, replicating the existing layout until a design pass occurs.

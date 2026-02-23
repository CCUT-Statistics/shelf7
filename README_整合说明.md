# XiunoBBS v4.0.7 整合包（Stately 主题 + 精简插件 + 123盘存储/备份）

本整合包目标：

- **前端体验**更接近「知乎 / 贴吧 / 小红书」风格（卡片化、封面图、互动、搜索、话题标签、私信/通知等）。
- **去掉无用/过时/强耦合插件**（尤其是缺依赖、商业/抽奖/复杂积分体系类），减少兼容问题。
- **新增 123盘对接插件 `pan123_storage`**：
  - 图片：本地保存 + 123盘备份（双写）
  - 文字：本地生成 json 备份 + 123盘备份（可选）
  - 视频：发帖页提供“上传视频到123盘”按钮，上传后自动生成分享/直链并插入编辑器

---

## 已整合内容

- **论坛本体**：xiunobbs v4.0.7
- **前端主题**：`abs_theme_stately` + 后台主题 `abs_themeacp_stately`
- **核心能力插件（已拷贝到 plugin/）**：
  - 搜索：`fox_search`
  - 话题/标签：`fox_tags`
  - 点赞：`haya_post_like`
  - 收藏：`haya_favorite`
  - 通知：`huux_notice`
  - 私信：`ax_notice_sx`（依赖 `huux_notice`）
  - 发帖体验：草稿 `till_thread_draft`、@提醒 `till_quick_at`
  - 内容呈现：主题封面 `till_thread_cover`、版块封面 `till_forum_cover`、用户封面 `till_user_cover`、灯箱预览 `till_lightbox`
  - 互动增强：楼中楼 `till_post_replies`、楼主标识 `till_post_author_badge`、回复链路 `till_post_view_chain`
  - 热门：`till_hot_thread`
  - 运营：签到 `sg_sign`（可选）
  - 管理：敏感词 `qt_sensitive_word`、反馈/举报 `ob_feedback`、小黑屋 `fox_prison`（可选）
  - 附件展示增强：`haya_post_attach_lite`（可选）
  - 第三方登录：QQ `iqismart_qqlogin` / 微信 `zz_iqismart_weixin`（可选）
  - 资源类：影视链接 `ac_movielink`、帖子口令 `till_thread_passcode`（可选）
  - **新增**：`pan123_storage`（123盘存储/备份）

> 注意：为了避免冲突，整合包将 `xn_search / xn_tag / xn_umeditor / huux_theme_simple / jiih_theme_single` 移入了 `plugin_disabled/`。

---

## 推荐启用顺序（后台 → 插件管理）

优先启用底层能力，再启用展示类：

1. `huux_notice`
2. `huux_tinymce`（编辑器）
3. `abs_themeacp_stately`（后台主题）
4. `abs_theme_stately`（前台主题）
5. `abs_menu`
6. `fox_search`
7. `fox_tags`
8. `haya_post_like`
9. `haya_favorite`
10. `ax_notice_sx`（私信）
11. `till_thread_cover` / `till_forum_cover` / `till_user_cover`
12. `till_lightbox`
13. `till_thread_draft`
14. `till_quick_at`
15. `till_post_replies`
16. `till_hot_thread`
17. `ob_feedback`
18. `qt_sensitive_word`
19. `pan123_storage`

可选：`sg_sign`、`haya_post_attach_lite`、`fox_prison`、`iqismart_qqlogin`、`zz_iqismart_weixin`、`ac_movielink`、`till_thread_passcode`。

---

## 123盘插件（pan123_storage）配置说明

后台进入：**插件 → 123盘存储/备份 → 设置**

### 1）基础配置

- `clientID` / `clientSecret`：在 123盘开放平台创建应用获得。
- 图片目录ID / 文字目录ID / 视频目录ID：建议你在 123盘先创建好目录，再把目录的 **fileID** 填进来。
- 重名策略：
  - `1` 保留两者（自动加后缀）
  - `2` 覆盖原文件

### 2）图片/文字双写

- 图片双写：开启后，在发帖流程中会同步上传图片到 123盘备份。
- 文字双写：开启后，在“发主题/回帖”时生成本地 json 备份并上传到 123盘。

> 性能提示：目前是**同步上传**（发帖会变慢）。后续建议改成：写入队列（表/kv）→ 定时任务/计划任务慢慢传。

### 3）视频上传

- 开启后，发帖页会出现：**上传视频(123盘)**。
- 上传成功后，会把分享链接或直链自动插入到编辑器。

#### 服务器侧限制

视频需要先传到你的站点，再由站点上传到 123盘，因此需保证 PHP/Nginx/Apache 配置允许大文件：

- `upload_max_filesize`
- `post_max_size`
- `max_execution_time`
- `client_max_body_size`（Nginx）

### 4）直链（可选）

- 直链接口可能需要你在 123盘开通相应能力（不同账号/套餐可能不同）。
- 若你启用了“直链鉴权”，请填 `uid` + `primary_key`，插件会自动为直链追加 `auth_key` 参数。

---

## 目录说明

- `plugin/`：整合后可直接使用的插件
- `plugin_disabled/`：被移出的默认插件（避免与 fox_search/fox_tags/huux_tinymce/主题冲突）
- `upload/pan123_backup/`：启用文字双写后生成的本地备份文件目录（运行时自动创建）

---

## 已主动剔除/不建议启用的插件类型

为了减少兼容问题与维护成本，整合包未包含（或建议不启用）：

- 缺依赖的积分/礼物/红包等复杂体系（例如依赖不存在的 `tt_credits`）
- 商城/拍卖/商户/支付等强业务插件（除非你的产品明确需要）
- 抽奖/彩蛋/运气贴等噪音运营插件
- “防红”等灰色用途插件
- 明显面向 Xiuno 5.0 的插件（如 `sa_noteapp`）

---

## 下一步建议（产品/技术）

- **小红书风格**：增加“瀑布流/多图卡片”列表（可在 Stately 主题 thread list 模板上改造）。
- **知乎风格**：增加“话题页（标签聚合）+ 热榜 + 关注”体系（关注可先做关注标签/关注版块）。
- **性能**：把 `pan123_storage` 的图片/文字双写改成队列异步，避免卡发帖。


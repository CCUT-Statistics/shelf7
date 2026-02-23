# 归档插件包说明

本目录用于存放**不参与当前运行与部署**的历史插件集合，避免主目录混入大量备选代码，同时保留后续二次启用能力。

## 目录用途

- `plugin_disab/`
  - 历史禁用/下线插件总仓（含多套来源与重复版本）。
  - 主要类别：
    - 主题与外观：如 `zaesky_theme_light`、`zaesky_theme_zhihulan`
    - 搜索/标签/编辑器：如 `xn_search`、`xn_tag`、`xn_umeditor`、`xn_tinymce`
    - 互动与用户：如 `haya_follow`、`haya_favorite`、`tt_sign`
    - 积分/勋章/VIP体系：如 `tt_credits`、`tt_medal`、`tt_vip`
    - 安全/运维辅助：如 `xiunobbs_cn_secure`、`xn_accesscount`
  - 建议：仅在测试环境单独验证后，再按需挑选复制回 `plugin/`。

- `optional/`
  - 精选可选插件包（当前保留 3 个）：
    - `chajian_selected/fox_plugincenter`：奇狐插件中心
    - `chajian_selected/fox_phpmailer`：PHPMailer 组件
    - `chajian_selected/cf_email_test`：邮件测试

## 使用流程（后续调用）

1. 从归档目录选择目标插件目录。
2. 复制到运行目录 `plugin/<plugin_dir>/`。
3. 后台“插件管理”执行安装/启用。
4. 按 `docs/SMOKE_TEST.md` 完成回归验证。

## 注意事项

- 归档目录默认不参与 `devkit/release/build-vps-test-release.ps1` 的测试包构建。
- `plugin_disab/` 内有重复插件与历史版本，避免一次性批量启用。

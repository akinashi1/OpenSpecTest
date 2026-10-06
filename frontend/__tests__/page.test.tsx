// spec: dev-environment / Requirement: 画面と DB 管理ツールにブラウザからアクセスできる
import { render, screen } from "@testing-library/react";
import { expect, test } from "vitest";
import Home from "@/app/page";

test("画面の初期ページが表示される", () => {
  render(<Home />);
  expect(screen.getByRole("heading", { level: 1 })).toBeDefined();
});

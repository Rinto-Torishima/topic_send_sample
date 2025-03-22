import { describe, it, expect, vi } from "vitest"
import { subscribeToTopic } from "@/composables/useTopic"

global.fetch = vi.fn() // fetch をモック

describe("subscribeToTopic", () => {
  it("正しいレスポンスを返す", async () => {
    const mockResponse = { message: "登録成功" }
    ;(fetch as unknown as vi.Mock).mockResolvedValue({
      json: async () => mockResponse,
    })

    const result = await subscribeToTopic("test-token", "test-topic")
    expect(result.message).toBe("登録成功")
  })
})

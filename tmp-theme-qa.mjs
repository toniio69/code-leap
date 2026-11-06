export default async function run(page, ui) {
    const bg = () =>
        page.evaluate(() => getComputedStyle(document.body).backgroundColor);
    const htmlClass = () =>
        page.evaluate(() => document.documentElement.className);

    const lightBg = await bg();
    const lightClass = await htmlClass();

    // Click the theme toggle
    await page.locator("button:has(svg)").first().click();
    await page.waitForTimeout(400);

    const darkBg = await bg();
    const darkClass = await htmlClass();
    const stored = await page.evaluate(() => localStorage.getItem("theme"));

    await page.screenshot({ path: "tmp-dark.png" });

    // Reload — theme must persist via the head script
    await page.reload();
    await page.waitForTimeout(500);
    const persistedClass = await htmlClass();
    const persistedBg = await bg();

    await page.screenshot({ path: "tmp-dark-reload.png" });

    // Toggle back to light
    await page.locator("button:has(svg)").first().click();
    await page.waitForTimeout(400);
    const backBg = await bg();
    const backClass = await htmlClass();
    const backStored = await page.evaluate(() => localStorage.getItem("theme"));

    await page.screenshot({ path: "tmp-light.png" });

    return {
        lightBg,
        lightClass,
        darkBg,
        darkClass,
        stored,
        persistedClass,
        persistedBg,
        backBg,
        backClass,
        backStored,
    };
}

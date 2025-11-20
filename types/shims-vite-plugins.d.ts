declare module '@tailwindcss/vite' {
    import type { Plugin } from 'vite';
    const tailwindcss: () => Plugin;
    export default tailwindcss;
}

declare module '@vitejs/plugin-vue' {
    import type { Plugin } from 'vite';
    interface VuePluginOptions {
        template?: any;
    }
    const vue: (options?: VuePluginOptions) => Plugin;
    export default vue;
}

declare module '@laravel/vite-plugin-wayfinder' {
    import type { Plugin } from 'vite';
    export function wayfinder(opts?: any): Plugin;
}


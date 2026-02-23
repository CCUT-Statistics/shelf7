new Vue({
	el:'#app',
	data(){
		return{
			test:'测试内容',
			activeName: 'GlobalSettings',
			}
	},
	mounted() {
	    // 页面加载完后修改 isLoading 的值
	    // window.addEventListener('load', () => {
	    //   this.isLoading = false;
	    // });
	  },
	  methods: {
	        handleClick(tab, event) {
	        //   console.log(tab, event);
	        }
	      }
})